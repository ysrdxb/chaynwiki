<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
        'icon',
        'category',
        'tier',
        'points',
        'requirements',
        'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
    ];

    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function getTierColorAttribute(): string
    {
        return match ($this->tier) {
            'bronze' => '#CD7F32',
            'silver' => '#C0C0C0',
            'gold' => '#FFD700',
            'platinum' => '#E5E4E2',
            default => '#6B7280',
        };
    }

    public function getTierBgAttribute(): string
    {
        return match ($this->tier) {
            'bronze' => 'bg-amber-700/20 border-amber-700/30',
            'silver' => 'bg-gray-400/20 border-gray-400/30',
            'gold' => 'bg-yellow-500/20 border-yellow-500/30',
            'platinum' => 'bg-purple-400/20 border-purple-400/30',
            default => 'bg-gray-500/20 border-gray-500/30',
        };
    }
}
