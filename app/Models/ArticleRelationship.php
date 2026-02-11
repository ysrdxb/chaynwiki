<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRelationship extends Model
{
    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the source article of the relationship.
     */
    public function source()
    {
        return $this->belongsTo(Article::class, 'source_id');
    }

    /**
     * Get the target article of the relationship.
     */
    public function target()
    {
        return $this->belongsTo(Article::class, 'target_id');
    }
}
