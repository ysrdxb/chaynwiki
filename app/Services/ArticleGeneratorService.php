<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use App\Models\AiGeneration;
use Illuminate\Support\Str;

/**
 * ArticleGeneratorService - AI-Powered Content Creation
 * 
 * Uses Ollama for free, local AI article generation.
 */
class ArticleGeneratorService
{
    public function __construct(
        private OllamaService $ollama
    ) {}

    /**
     * Generate a complete article draft
     */
    public function generateDraft(string $topic, string $category = 'general', ?int $userId = null): ?array
    {
        $startTime = microtime(true);
        
        $prompt = $this->buildPrompt($topic, $category);
        
        $response = $this->ollama->generate($prompt, null, [
            'temperature' => 0.7,
            'top_p' => 0.9,
        ]);

        $generationTime = round(microtime(true) - $startTime, 2);

        // Log generation
        AiGeneration::create([
            'user_id' => $userId,
            'type' => 'article',
            'model' => config('services.ollama.model', 'llama3'),
            'prompt' => $prompt,
            'response' => $response,
            'status' => $response ? 'completed' : 'failed',
            'generation_time' => $generationTime,
            'metadata' => [
                'topic' => $topic,
                'category' => $category,
            ],
        ]);

        if (!$response) {
            return null;
        }

        return [
            'title' => $this->generateTitle($topic),
            'slug' => Str::slug($topic),
            'content' => $response,
            'excerpt' => $this->generateExcerpt($response),
            'category' => $category,
            'generated_at' => now(),
            'generation_time' => $generationTime,
        ];
    }

    /**
     * Generate article summary/excerpt
     */
    public function generateSummary(string $content, int $maxWords = 50): ?string
    {
        $prompt = "Summarize this music wiki article in {$maxWords} words or less. Be factual and engaging:\n\n{$content}";
        
        return $this->ollama->generate($prompt, null, ['temperature' => 0.3]);
    }

    /**
     * Suggest improvements for existing content
     */
    public function suggestImprovements(string $content): ?array
    {
        $prompt = <<<PROMPT
Analyze this music wiki article and suggest improvements. Return JSON with:
- missing_sections: array of sections that could be added
- factual_concerns: array of statements that need citations
- readability_issues: array of readability improvements
- suggested_tags: array of 5 relevant tags

Article:
{$content}

Respond ONLY with valid JSON.
PROMPT;

        $response = $this->ollama->generate($prompt, null, ['temperature' => 0.3]);
        
        if (!$response) {
            return null;
        }

        try {
            return json_decode($response, true);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Expand a section with more detail
     */
    public function expandSection(string $section, string $context = ''): ?string
    {
        $prompt = "Expand this section of a music wiki article with more detail, facts, and context. Keep an encyclopedic tone.\n\nSection: {$section}\n\nContext: {$context}";
        
        return $this->ollama->generate($prompt);
    }

    /**
     * Build category-specific prompt
     */
    private function buildPrompt(string $topic, string $category): string
    {
        $templates = [
            'song' => <<<PROMPT
Write a comprehensive music wiki article about the song "{$topic}".

Include these sections with markdown headers (##):
## Background
- Recording history, production details, inspiration

## Composition
- Musical analysis, key, tempo, instrumentation

## Lyrics
- Lyrical themes, meaning, notable lines (do not include full lyrics due to copyright)

## Reception
- Critical reception, chart performance, certifications

## Cultural Impact
- Use in media, covers, samples, influence

## Legacy
- Long-term significance, how it's remembered today

Write in an encyclopedic, neutral tone. Use facts where known, and be clear when speculating.
PROMPT,

            'artist' => <<<PROMPT
Write a comprehensive music wiki article about the artist/band "{$topic}".

Include these sections with markdown headers (##):
## Early Life and Background
- Origins, formation, early influences

## Career
- Career timeline, major releases, evolution

## Musical Style
- Genre, influences, signature sound, production style

## Discography Highlights
- Key albums and singles, collaborations

## Awards and Recognition
- Major awards, chart achievements, records

## Legacy and Influence
- Impact on music, influenced artists, cultural significance

Write in an encyclopedic, neutral tone.
PROMPT,

            'genre' => <<<PROMPT
Write a comprehensive music wiki article about the music genre "{$topic}".

Include these sections with markdown headers (##):
## Origins
- When and where it emerged, cultural context

## Musical Characteristics
- Tempo, instruments, production techniques, typical structures

## History
- Timeline of development, major eras

## Key Artists
- Pioneers and current notable artists

## Subgenres
- Related subgenres and fusion genres

## Cultural Impact
- Influence on fashion, culture, other genres

Write in an encyclopedic, neutral tone.
PROMPT,

            'general' => <<<PROMPT
Write a comprehensive music wiki article about "{$topic}".

Structure the article with relevant markdown headers (##) based on the topic.
Include factual information, historical context, and cultural significance.
Write in an encyclopedic, neutral tone.
Be thorough but concise. Aim for well-researched, informative content.
PROMPT,
        ];

        return $templates[$category] ?? $templates['general'];
    }

    /**
     * Generate a clean title
     */
    private function generateTitle(string $topic): string
    {
        return Str::title(trim($topic));
    }

    /**
     * Extract excerpt from content
     */
    private function generateExcerpt(string $content, int $length = 200): string
    {
        // Remove markdown headers
        $clean = preg_replace('/^##?\s+.+$/m', '', $content);
        $clean = trim($clean);
        
        return Str::limit($clean, $length, '...');
    }
}
