<?php

declare(strict_types=1);

namespace App\Services;

/**
 * OllamaService - Legacy Wrapper for AIService
 * 
 * To ensure zero-breakage across the existing codebase while
 * transitioning to the multi-driver AIService.
 */
class OllamaService extends AIService
{
    /**
     * Re-implementing analyzeLyrics as it was specific in the original service
     */
    public function analyzeLyrics(string $lyrics): ?array
    {
        $prompt = <<<PROMPT
Analyze these song lyrics and provide a JSON response with:
- themes: array of main themes (max 5)
- mood: primary mood (happy, sad, aggressive, calm, nostalgic, etc.)
- mood_score: 1-10 intensity
- literary_devices: array of devices found (metaphor, simile, alliteration, etc.)
- rhyme_scheme: the rhyme pattern (ABAB, AABB, free verse, etc.)
- summary: 2-3 sentence summary of the song's meaning

Lyrics:
{$lyrics}

Respond ONLY with valid JSON, no other text.
PROMPT;

        $response = $this->generate($prompt, null, ['temperature' => 0.3]);
        
        if (!$response) return null;

        try {
            // Some models might wrap JSON in markdown blocks
            if (str_contains($response, '```json')) {
                $response = \Illuminate\Support\Str::between($response, '```json', '```');
            } elseif (str_contains($response, '```')) {
                $response = \Illuminate\Support\Str::between($response, '```', '```');
            }

            return json_decode(trim($response), true) ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Legacy method for suggesting search terms
     */
    public function suggestSearchTerms(string $query, array $existingTopics = []): array
    {
        $topicsStr = implode(', ', array_slice($existingTopics, 0, 20));
        
        $prompt = <<<PROMPT
Given the search query "{$query}" on a music wiki platform, suggest 5 related search terms.
Existing topics include: {$topicsStr}

Return ONLY a JSON array of 5 strings, nothing else.
PROMPT;

        $response = $this->generate($prompt, null, ['temperature' => 0.5]);
        
        if (!$response) return [];

        try {
            if (str_contains($response, '```json')) {
                $response = \Illuminate\Support\Str::between($response, '```json', '```');
            } elseif (str_contains($response, '```')) {
                $response = \Illuminate\Support\Str::between($response, '```', '```');
            }
            return json_decode(trim($response), true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
