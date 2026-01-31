<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $guarded = [];

    protected $casts = [
        'related_terms' => 'array',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
