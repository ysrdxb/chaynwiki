<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crate extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'color_accent'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'crate_articles')
                    ->withPivot('notes')
                    ->withTimestamps();
    }
}
