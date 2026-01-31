<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleAnalysis extends Model
{
    protected $table = 'article_analyses';

    protected $fillable = [
        'article_id',
        'themes',
        'mood',
        'mood_score',
        'literary_devices',
        'rhyme_scheme',
        'summary',
        'quality_score',
        'readability_score',
        'suggested_tags',
        'related_articles',
        'analyzed_at',
        'ambient_signature',
        'emotional_resonance',
    ];

    protected $casts = [
        'themes' => 'array',
        'literary_devices' => 'array',
        'suggested_tags' => 'array',
        'related_articles' => 'array',
        'ambient_signature' => 'array',
        'analyzed_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function getAmbientGradientCssAttribute(): string
    {
        $signature = $this->ambient_signature ?: [
            'gradient' => ['#050510', '#0A0A1F', '#12123A', '#3b82f6']
        ];

        $colors = implode(', ', $signature['gradient'] ?? []);
        return "linear-gradient(135deg, {$colors})";
    }

    public function getMoodColorAttribute(): string
    {
        $moodColors = [
            'happy' => '#10B981',
            'upbeat' => '#F59E0B',
            'sad' => '#3B82F6',
            'melancholic' => '#6366F1',
            'aggressive' => '#EF4444',
            'calm' => '#06B6D4',
            'nostalgic' => '#8B5CF6',
            'hopeful' => '#22C55E',
            'dark' => '#1F2937',
        ];

        return $moodColors[strtolower($this->mood ?? '')] ?? '#6B7280';
    }

    public function getMoodIntensityPercentAttribute(): int
    {
        return ($this->mood_score ?? 5) * 10;
    }
}
