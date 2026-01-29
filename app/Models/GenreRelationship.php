<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenreRelationship extends Model
{
    protected $fillable = [
        'source_genre_id',
        'target_genre_id',
        'relationship_type',
        'strength',
        'description',
    ];

    public function sourceGenre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'source_genre_id');
    }

    public function targetGenre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'target_genre_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->relationship_type) {
            'influences' => 'Influenced',
            'derived_from' => 'Derived From',
            'fusion_of' => 'Fusion Of',
            'similar_to' => 'Similar To',
            default => ucfirst($this->relationship_type),
        };
    }
}
