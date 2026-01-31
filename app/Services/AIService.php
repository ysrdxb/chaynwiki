<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * AIService - Unified AI Interface
 * 
 * Supports multiple drivers:
 * - groq: Ultra-fast free cloud AI (recommended)
 * - openai: Industry standard (paid)
 * - ollama: Local-only free AI
 */
class AIService
{
    protected string $driver;
    protected array $config;
    protected int $timeout;

    public function __construct()
    {
        $this->driver = config('services.ai.driver', 'ollama');
        $this->config = config("services.{$this->driver}", []);
        $this->timeout = config("services.ollama.timeout", 30); // Use 30s as a safer default for cloud
    }

    /**
     * Common method to generate an 'Ambient Signature'.
     */
    public function generateAmbientSignature(string $content): array
    {
        $prompt = "Analyze the musical and emotional frequency of this content. 
                  Provide a 'Sonic DNA' profile including:
                  1. Dominant Emotion (e.g. Melancholic, Aggressive, Ethereal)
                  2. Energy Level (1-10)
                  3. A 4-color gradient hex array (e.g. ['#1A1A2E', '#16213E', '#0F3460', '#E94560']) that represents this vibe.
                  
                  Return ONLY a JSON object: {\"emotion\": string, \"energy\": int, \"gradient\": array}";

        $response = $this->generate($prompt . "\n\nContent: " . Str::limit($content, 1000));

        try {
            // Some models might wrap JSON in markdown blocks
            if (str_contains($response, '```json')) {
                $response = Str::between($response, '```json', '```');
            } elseif (str_contains($response, '```')) {
                $response = Str::between($response, '```', '```');
            }
            
            return json_decode(trim($response), true) ?: $this->getDefaultSignature();
        } catch (\Exception $e) {
            return $this->getDefaultSignature();
        }
    }

    private function getDefaultSignature(): array
    {
        return [
            'emotion' => 'Atmospheric',
            'energy' => 7,
            'gradient' => ['#050510', '#0a0a2e', '#1e1e4a', '#3b82f6']
        ];
    }

    /**
     * Unified generation method.
     */
    public function generate(string $prompt, ?string $model = null, array $options = []): ?string
    {
        return match ($this->driver) {
            'groq' => $this->generateGroq($prompt, $model, $options),
            'openai' => $this->generateOpenAI($prompt, $model, $options),
            'ollama' => $this->generateOllama($prompt, $model, $options),
            default => $this->mockGeneratedContent($prompt),
        };
    }

    protected function generateGroq(string $prompt, ?string $model = null, array $options = []): ?string
    {
        if (empty($this->config['key'])) {
            return $this->mockGeneratedContent($prompt);
        }

        try {
            $response = Http::withToken($this->config['key'])
                ->timeout($this->timeout)
                ->post("{$this->config['url']}/chat/completions", [
                    'model' => $model ?? $this->config['model'],
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                    'temperature' => $options['temperature'] ?? 0.7,
                    'stream' => false,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
        } catch (\Exception $e) {
            Log::warning('Groq connection failed', ['error' => $e->getMessage()]);
        }

        return $this->mockGeneratedContent($prompt);
    }

    protected function generateOpenAI(string $prompt, ?string $model = null, array $options = []): ?string
    {
        if (empty($this->config['key'])) {
            return $this->mockGeneratedContent($prompt);
        }

        try {
            $response = Http::withToken($this->config['key'])
                ->timeout($this->timeout)
                ->post("https://api.openai.com/v1/chat/completions", [
                    'model' => $model ?? $this->config['model'],
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                    'temperature' => $options['temperature'] ?? 0.7,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
        } catch (\Exception $e) {
            Log::warning('OpenAI connection failed', ['error' => $e->getMessage()]);
        }

        return $this->mockGeneratedContent($prompt);
    }

    protected function generateOllama(string $prompt, ?string $model = null, array $options = []): ?string
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post("{$this->config['url']}/api/generate", [
                    'model' => $model ?? $this->config['model'],
                    'prompt' => $prompt,
                    'stream' => false,
                ]);

            if ($response->successful()) {
                return $response->json('response');
            }
        } catch (\Exception $e) {
            Log::debug('Ollama failed, falling back to mock.');
        }

        return $this->mockGeneratedContent($prompt);
    }

    /**
     * Unified chat method.
     */
    public function chat(array $messages, ?string $model = null): ?string
    {
        if ($this->driver === 'ollama') {
            try {
                $response = Http::timeout($this->timeout)
                    ->post("{$this->config['url']}/api/chat", [
                        'model' => $model ?? $this->config['model'],
                        'messages' => $messages,
                        'stream' => false,
                    ]);
                if ($response->successful()) {
                    return $response->json('message.content');
                }
            } catch (\Exception $e) {}
        } else {
            // OpenAI and Groq share the same chat format
            $endpoint = $this->driver === 'groq' ? "{$this->config['url']}/chat/completions" : "https://api.openai.com/v1/chat/completions";
            try {
                $response = Http::withToken($this->config['key'])
                    ->timeout($this->timeout)
                    ->post($endpoint, [
                        'model' => $model ?? $this->config['model'],
                        'messages' => $messages,
                    ]);
                if ($response->successful()) {
                    return $response->json('choices.0.message.content');
                }
            } catch (\Exception $e) {}
        }

        if (config('services.ai.demo_mode', false)) {
            return "I am currently operating in **Demo Mode**. While my full AI uplink is being configured, I can tell you that ChaynWiki is a premium archival project dedicated to preserving the sonic history of global music. How can I help you explore our records today?";
        }

        return "I'm currently in static mode. My AI uplink is unreachable.";
    }

    /**
     * Article generation logic.
     */
    public function generateArticle(string $topic, string $category = 'general'): ?array
    {
        $prompt = match($category) {
            'song' => "Write a comprehensive music wiki article about the song \"{$topic}\". Include sections for: Background, Lyrics Analysis, and Impact.",
            'artist' => "Write a comprehensive music wiki article about the artist \"{$topic}\". Include sections for: Early Life, Career, and Legacy.",
            default => "Write a comprehensive music wiki article about \"{$topic}\".",
        };
        
        $content = $this->generate($prompt);
        
        return $content ? [
            'title' => $topic,
            'content' => $content,
            'generated_at' => now(),
        ] : null;
    }

    /**
     * Check if the selected driver is available.
     */
    public function isAvailable(): bool
    {
        if (config('services.ai.demo_mode', false)) return true;

        if ($this->driver === 'ollama') {
            try {
                return Http::timeout(2)->get("{$this->config['url']}/api/tags")->successful();
            } catch (\Exception $e) { return false; }
        }

        return !empty($this->config['key']);
    }

    /**
     * Mock content to ensure UI never breaks.
     */
    protected function mockGeneratedContent(string $prompt): string
    {
        if (str_contains($prompt, 'JSON')) {
            return json_encode($this->getDefaultSignature());
        }

        return "This is a high-fidelity placeholder generated because the AI service is currently processing data. The content represents the core themes and historical significance of the requested topic, maintained within the ChaynWiki archival standards.";
    }
}
