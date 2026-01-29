<?php

namespace App\Console\Commands;

use App\Services\OllamaService;
use Illuminate\Console\Command;

class TestOllama extends Command
{
    protected $signature = 'ollama:test {--prompt= : Custom prompt to test}';
    protected $description = 'Test Ollama AI connection and generate a sample response';

    public function handle(OllamaService $ollama): int
    {
        $this->info('🤖 Testing Ollama Connection...');
        $this->newLine();

        // Check if Ollama is running
        if (!$ollama->isAvailable()) {
            $this->error('❌ Ollama is not running!');
            $this->newLine();
            $this->warn('To fix this:');
            $this->line('1. Install Ollama: https://ollama.com/download');
            $this->line('2. Start Ollama (it runs in background)');
            $this->line('3. Pull a model: ollama pull llama3');
            return Command::FAILURE;
        }

        $this->info('✅ Ollama is running!');
        $this->newLine();

        // List available models
        $models = $ollama->getModels();
        if (empty($models)) {
            $this->warn('⚠️ No models found. Pull one with: ollama pull llama3');
            return Command::FAILURE;
        }

        $this->info('📦 Available models:');
        foreach ($models as $model) {
            $this->line("   - {$model}");
        }
        $this->newLine();

        // Test generation
        $prompt = $this->option('prompt') ?? 'Write a one-paragraph description of jazz music in an encyclopedic style.';
        
        $this->info('🧪 Testing generation...');
        $this->line("Prompt: {$prompt}");
        $this->newLine();

        $start = microtime(true);
        $response = $ollama->generate($prompt);
        $elapsed = round(microtime(true) - $start, 2);

        if ($response) {
            $this->info("✅ Generation successful ({$elapsed}s)");
            $this->newLine();
            $this->line('Response:');
            $this->line('─────────────────────────────────────────');
            $this->line($response);
            $this->line('─────────────────────────────────────────');
            $this->newLine();
            $this->info('🎉 Ollama is ready for ChaynWiki!');
            return Command::SUCCESS;
        }

        $this->error('❌ Generation failed. Check logs for details.');
        return Command::FAILURE;
    }
}
