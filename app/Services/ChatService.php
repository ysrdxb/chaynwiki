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

        return $this->ollama->chat($messages);
    }

    /**
     * Get quick response for simple queries
     */
    public function quickAnswer(string $question): ?string
    {
        $prompt = <<<PROMPT
You are ChaynWiki's AI assistant. Answer this music-related question concisely in 2-3 sentences.
If you don't know, say so. Don't make up facts.

Question: {$question}
PROMPT;

        return $this->ollama->generate($prompt, null, ['temperature' => 0.5]);
    }

    /**
     * Get suggested follow-up questions
     */
    public function getSuggestions(string $topic): array
    {
        $prompt = <<<PROMPT
Given someone is asking about "{$topic}" on a music wiki, suggest 3 follow-up questions they might ask.
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
Your knowledge covers:
- Music genres, history, and evolution
- Artists, bands, and their discographies
- Songs, albums, and their cultural impact
- Music theory and production
- Music industry and trends

Guidelines:
- Be helpful, accurate, and engaging
- Use a friendly but informative tone
- If you're unsure, say so rather than making up facts
- Suggest related topics when relevant
- Keep responses concise but comprehensive
PROMPT;

        if ($articleContext) {
            $base .= "\n\nContext from the current article:\n{$articleContext}";
        }

        return $base;
    }

    /**
     * Default suggestions when AI fails
     */
    private function getDefaultSuggestions(): array
    {
        return [
            "What are the most popular genres right now?",
            "Tell me about the history of hip hop",
            "Who are some influential artists from the 90s?",
        ];
    }
}
