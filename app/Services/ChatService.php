<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;

/**
 * ChatService - AI Chat Assistant for ChaynWiki
 * 
 * Provides contextual Q&A about music using Ollama.
 */
class ChatService
{
    private const MAX_CONTEXT_ARTICLES = 5;
    private const MAX_HISTORY_MESSAGES = 10;

    public function __construct(
        private OllamaService $ollama
    ) {}

    /**
     * Send a message and get a response with context
     */
    public function chat(string $message, array $history = [], ?string $articleContext = null): ?string
    {
        $startTime = microtime(true);
        $systemPrompt = $this->buildSystemPrompt($articleContext);
        
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        // Add recent history (limited)
        foreach (array_slice($history, -self::MAX_HISTORY_MESSAGES) as $msg) {
            $messages[] = $msg;
        }

        // Add current message
        $messages[] = ['role' => 'user', 'content' => $message];

        $response = $this->ollama->chat($messages);

        if ($response) {
            $this->logGeneration('chat', $message, $response, $startTime, [
                'has_context' => !empty($articleContext),
                'history_count' => count($history)
            ]);
        }

        return $response;
    }

    /**
     * Get quick response for simple queries
     */
    public function quickAnswer(string $question): ?string
    {
        $startTime = microtime(true);
        $prompt = <<<PROMPT
You are ChaynWiki's AI assistant. Answer this music-related question concisely in 2-3 sentences.
If you don't know, say so. Don't make up facts.

Question: {$question}
PROMPT;

        $response = $this->ollama->generate($prompt, null, ['temperature' => 0.5]);

        if ($response) {
            $this->logGeneration('quick_answer', $question, $response, $startTime);
        }

        return $response;
    }

    /**
     * Get suggested follow-up questions
     */
    public function getSuggestions(string $topic): array
    {
        $prompt = <<<PROMPT
Given someone is asking about "{$topic}" on a music wiki, suggest 3 follow-up questions they might ask.
Include at least one question that starts a "Music Trivia Challenge" or asks for a "Comparison" if relevant.
Return ONLY a JSON array of 3 strings. No other text.
PROMPT;

        $response = $this->ollama->generate($prompt, null, ['temperature' => 0.7]);
        
        if (!$response) {
            return $this->getDefaultSuggestions();
        }

        try {
            $suggestions = json_decode($response, true);
            return is_array($suggestions) ? array_slice($suggestions, 0, 3) : $this->getDefaultSuggestions();
        } catch (\Exception $e) {
            return $this->getDefaultSuggestions();
        }
    }

    /**
     * Search for relevant articles to provide context
     */
    public function findRelevantContext(string $query): string
    {
        // Simple keyword search in articles
        $articles = Article::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->limit(self::MAX_CONTEXT_ARTICLES)
            ->get(['title', 'content', 'category']);

        if ($articles->isEmpty()) {
            return '';
        }

        $context = "Here is relevant information from ChaynWiki:\n\n";
        
        foreach ($articles as $article) {
            $excerpt = \Illuminate\Support\Str::limit(strip_tags($article->content), 500);
            $context .= "**{$article->title}** ({$article->category})\n{$excerpt}\n\n";
        }

        return $context;
    }

    /**
     * Build system prompt with optional context
     */
    private function buildSystemPrompt(?string $articleContext = null): string
    {
        $base = <<<PROMPT
You are ChaynWiki AI, an expert assistant on the music wiki platform ChaynWiki.
Your knowledge covers genres, artists, songs, music history, and industry trends.

Capabilities:
- **Article Explainer**: Help users understand the current wiki page. Use the provided context to answer specifically.
- **Music Trivia**: You can create quizzes and challenges if asked.
- **Comparisons**: You can analyze differences between artists, genres, or albums.

Guidelines:
- Be helpful, accurate, and engaging.
- Use Markdown for better formatting (lists, bold text, etc.).
- If you're unsure, say so rather than making up facts.
- Suggest related topics when relevant.
- Keep responses concise but comprehensive.
PROMPT;

        if ($articleContext) {
            $base .= "\n\nCRITICAL CONTEXT (The user is currently reading this):\n{$articleContext}";
        }

        return $base;
    }

    /**
     * Log the AI generation to the database
     */
    private function logGeneration(string $type, string $prompt, string $response, float $startTime, array $metadata = []): void
    {
        try {
            \App\Models\AiGeneration::create([
                'user_id' => auth()->id(),
                'type' => $type,
                'model' => 'ollama/llama3', // Assumption, could be dynamic
                'prompt' => $prompt,
                'response' => $response,
                'status' => 'completed',
                'generation_time' => microtime(true) - $startTime,
                'metadata' => $metadata,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to log AI generation: ' . $e->getMessage());
        }
    }

    /**
     * Default suggestions when AI fails
     */
    private function getDefaultSuggestions(): array
    {
        return [
            "Start a music trivia challenge!",
            "Explain the history of the current article",
            "Compare this artist with similar ones",
        ];
    }
}
