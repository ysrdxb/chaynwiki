<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $guarded = [];

    protected $casts = [
        'active_from' => 'date',
        'active_to' => 'date',
        'social_links' => 'array',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
