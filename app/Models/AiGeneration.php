<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiGeneration extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'model',
        'prompt',
        'response',
        'status',
        'tokens_used',
        'generation_time',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'generation_time' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
