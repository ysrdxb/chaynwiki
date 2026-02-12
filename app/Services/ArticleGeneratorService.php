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

        // Parse Neural Connections
        $tags = [];
        $content = $response;
        
        if (preg_match('/## Neural Connections\s+(.+)$/s', $response, $matches)) {
            // Extract tags
            $tagText = trim($matches[1]);
            // Remove bullet points if present
            $tagText = preg_replace('/^\s*-\s*/m', '', $tagText);
            $tags = array_map('trim', explode(',', str_replace("\n", ',', $tagText)));
            $tags = array_filter($tags); // Remove empty
            $tags = array_slice($tags, 0, 8); // Limit to 8

            // Remove the section from content
            $content = preg_replace('/## Neural Connections\s+.+$/s', '', $response);
        }

        return [
            'title' => $this->generateTitle($topic),
            'slug' => Str::slug($topic),
            'content' => trim($content),
            'tags' => $tags,
            'excerpt' => $this->generateExcerpt($content),
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
        $basePrompt = match($category) {
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
PROMPT,
            'playlist' => <<<PROMPT
Write a comprehensive curator's note and description for a music playlist titled "{$topic}".

Include these sections with markdown headers (##):
## Concept
- The central theme, mood, or idea behind this collection

## Featured Artists
- Key artists included in this playlist and their significance

## Musical Journey
- Flow of the playlist, progression of energy

## Context
- When/where to listen, historical context if applicable
PROMPT,
            'term' => <<<PROMPT
Write a comprehensive music glossary definition for the term "{$topic}".

Include these sections with markdown headers (##):
## Definition
- Clear, concise definition of the term

## Etymology
- Origin of the word/phrase

## Usage in Music
- How it is applied in music theory, production, or culture

## Examples
- Notable examples of this term in action

## Related Terms
- Similar or contrasting concepts
PROMPT,
            'general' => <<<PROMPT
Write a comprehensive music wiki article about "{$topic}".

Structure the article with relevant markdown headers (##) based on the topic.
Include factual information, historical context, and cultural significance.
PROMPT,
        };

        return $basePrompt . "\n\n" . <<<PROMPT
## Neural Connections
- Provide a comma-separated list of 5-8 related concepts, artists, genres, or moods for the knowledge graph.

Write in an encyclopedic, neutral tone. Use facts where known, and be clear when speculating.
PROMPT;
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
        $clean = preg_replace('/## Neural Connections.*$/s', '', $clean);
        $clean = trim($clean);
        
        return Str::limit($clean, $length, '...');
    }
}
