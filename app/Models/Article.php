<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Dynamic relationships based on category? 
    // Usually polymorphic is better, but here we have explicit tables linked by article_id.
    
    public function song()
    {
        return $this->hasOne(Song::class);
    }

    public function artist()
    {
        return $this->hasOne(Artist::class);
    }

    public function genre()
    {
        return $this->hasOne(Genre::class);
    }

    public function playlist()
    {
        return $this->hasOne(Playlist::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class)->latest();
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
