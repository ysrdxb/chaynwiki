<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleAnalysis;
use Illuminate\Support\Str;

/**
 * LyricAnalysisService - AI-Powered Lyric Analysis
 * 
 * Analyzes lyrics for themes, mood, rhyme schemes, and literary devices.
 */
class LyricAnalysisService
{
    public function __construct(
        private OllamaService $ollama
    ) {}

    /**
     * Perform comprehensive analysis on lyrics
     */
    public function analyze(string $lyrics, ?int $articleId = null): ?array
    {
        $analysis = $this->getAIAnalysis($lyrics);
        
        if (!$analysis) {
            return null;
        }

        // Store in database if article ID provided
        if ($articleId) {
            $this->storeAnalysis($articleId, $analysis);
        }

        // Add computed metrics
        $analysis['word_count'] = str_word_count($lyrics);
        $analysis['line_count'] = count(array_filter(explode("\n", $lyrics)));
        $analysis['unique_words'] = count(array_unique(str_word_count(strtolower($lyrics), 1)));
        $analysis['rhyme_visualization'] = $this->generateRhymeVisualization($lyrics, $analysis['rhyme_scheme'] ?? 'unknown');

        return $analysis;
    }

    /**
     * Get AI-powered analysis from Ollama
     */
    private function getAIAnalysis(string $lyrics): ?array
    {
        $prompt = <<<PROMPT
Analyze these song lyrics comprehensively. Return a JSON object with:

{
  "themes": ["array of 3-5 main themes like 'love', 'struggle', 'celebration'"],
  "mood": "primary mood (happy, sad, aggressive, calm, nostalgic, melancholic, hopeful, dark, upbeat)",
  "mood_score": "1-10 intensity where 10 is most intense",
  "energy": "low, medium, or high",
  "literary_devices": [
    {"type": "metaphor", "example": "example from lyrics", "line": 1},
    {"type": "simile", "example": "example", "line": 3}
  ],
  "rhyme_scheme": "pattern like ABAB, AABB, or 'free verse'",
  "vocabulary_level": "simple, moderate, or complex",
  "summary": "2-3 sentence summary of what the song is about",
  "notable_lines": ["most impactful or quotable lines"],
  "genre_hints": ["genres this style suggests like 'hip-hop', 'pop', 'rock'"]
}

LYRICS:
{$lyrics}

Return ONLY valid JSON, no other text or markdown.
PROMPT;

        $response = $this->ollama->generate($prompt, null, [
            'temperature' => 0.3,
        ]);

        if (!$response) {
            return null;
        }

        // Clean response (remove markdown code blocks if present)
        $cleaned = preg_replace('/^```json\s*|\s*```$/m', '', trim($response));
        
        try {
            $parsed = json_decode($cleaned, true);
            return is_array($parsed) ? $parsed : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Detect rhyme scheme from lyrics
     */
    public function detectRhymeScheme(string $lyrics): string
    {
        $lines = array_filter(array_map('trim', explode("\n", $lyrics)));
        
        if (count($lines) < 2) {
            return 'N/A';
        }

        // Get last words of each line
        $endWords = [];
        foreach ($lines as $line) {
            $words = preg_split('/\s+/', trim($line));
            if (!empty($words)) {
                $lastWord = preg_replace('/[^a-zA-Z]/', '', end($words));
                $endWords[] = strtolower($lastWord);
            }
        }

        // Simple phonetic ending matching
        $pattern = [];
        $rhymeMap = [];
        $currentLetter = 'A';

        foreach ($endWords as $word) {
            $ending = $this->getPhoneticEnding($word);
            
            if (isset($rhymeMap[$ending])) {
                $pattern[] = $rhymeMap[$ending];
            } else {
                $rhymeMap[$ending] = $currentLetter;
                $pattern[] = $currentLetter;
                $currentLetter = chr(ord($currentLetter) + 1);
            }
        }

        return implode('', array_slice($pattern, 0, 8)); // First 8 lines
    }

    /**
     * Get phonetic ending of a word (simplified)
     */
    private function getPhoneticEnding(string $word): string
    {
        $word = strtolower($word);
        
        // Return last 3 characters or full word if shorter
        return strlen($word) > 3 ? substr($word, -3) : $word;
    }

    /**
     * Generate visual representation of rhyme scheme
     */
    public function generateRhymeVisualization(string $lyrics, string $scheme): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $lyrics)));
        $colors = [
            'A' => '#EF4444', // red
            'B' => '#3B82F6', // blue
            'C' => '#10B981', // green
            'D' => '#F59E0B', // yellow
            'E' => '#8B5CF6', // purple
            'F' => '#EC4899', // pink
            'G' => '#06B6D4', // cyan
            'H' => '#F97316', // orange
        ];

        $schemeArray = str_split($scheme);
        $visualization = [];

        foreach ($lines as $index => $line) {
            $letter = $schemeArray[$index] ?? 'X';
            $visualization[] = [
                'line' => $line,
                'letter' => $letter,
                'color' => $colors[$letter] ?? '#6B7280',
                'index' => $index + 1,
            ];
        }

        return $visualization;
    }

    /**
     * Analyze mood and return detailed breakdown
     */
    public function analyzeMood(string $lyrics): array
    {
        $prompt = <<<PROMPT
Analyze the emotional mood of these lyrics. Return JSON with:
{
  "primary_mood": "the main emotion",
  "secondary_moods": ["other emotions present"],
  "intensity": 1-10,
  "progression": "describe how the mood changes through the song",
  "emotional_keywords": ["words that convey the mood"]
}

Lyrics: {$lyrics}

Return ONLY valid JSON.
PROMPT;

        $response = $this->ollama->generate($prompt, null, ['temperature' => 0.3]);
        
        if (!$response) {
            return [
                'primary_mood' => 'unknown',
                'secondary_moods' => [],
                'intensity' => 5,
            ];
        }

        try {
            return json_decode($response, true) ?? ['primary_mood' => 'unknown'];
        } catch (\Exception $e) {
            return ['primary_mood' => 'unknown'];
        }
    }

    /**
     * Store analysis in database
     */
    private function storeAnalysis(int $articleId, array $analysis): void
    {
        ArticleAnalysis::updateOrCreate(
            ['article_id' => $articleId],
            [
                'themes' => $analysis['themes'] ?? [],
                'mood' => $analysis['mood'] ?? null,
                'mood_score' => $analysis['mood_score'] ?? null,
                'literary_devices' => $analysis['literary_devices'] ?? [],
                'rhyme_scheme' => $analysis['rhyme_scheme'] ?? null,
                'summary' => $analysis['summary'] ?? null,
                'suggested_tags' => $analysis['genre_hints'] ?? [],
                'analyzed_at' => now(),
            ]
        );
    }

    /**
     * Get cached analysis for an article
     */
    public function getCachedAnalysis(int $articleId): ?ArticleAnalysis
    {
        return ArticleAnalysis::where('article_id', $articleId)->first();
    }

    /**
     * Perform batch analysis on multiple articles
     */
    public function batchProcess(array $articleIds): array
    {
        $results = [
            'total' => count($articleIds),
            'processed' => 0,
            'failed' => 0,
            'details' => []
        ];

        foreach ($articleIds as $id) {
            $article = Article::find($id);
            if (!$article || empty($article->content)) {
                $results['failed']++;
                $results['details'][] = ['id' => $id, 'status' => 'error', 'message' => 'Article not found or empty'];
                continue;
            }

            try {
                $analysis = $this->analyze($article->content, $article->id);
                if ($analysis) {
                    $results['processed']++;
                    $results['details'][] = ['id' => $id, 'status' => 'success'];
                } else {
                    $results['failed']++;
                    $results['details'][] = ['id' => $id, 'status' => 'failed'];
                }
            } catch (\Exception $e) {
                $results['failed']++;
                $results['details'][] = ['id' => $id, 'status' => 'error', 'message' => $e->getMessage()];
            }

            // Simple throttle to avoid overwhelming local Ollama
            usleep(500000); // 0.5s pause
        }

        return $results;
    }
}
