<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Genre::class, 'parent_genre_id');
    }

    public function children()
    {
        return $this->hasMany(Genre::class, 'parent_genre_id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
