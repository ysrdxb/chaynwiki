<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'brand',
        'description',
        'image',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_gear')
                    ->withPivot('usage_notes')
                    ->withTimestamps();
    }
}
