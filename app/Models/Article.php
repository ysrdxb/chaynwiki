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

    public function getFeaturedImageAttribute($value)
    {
        if ($value) {
            return \Illuminate\Support\Facades\Storage::url($value);
        }

        // Return high-quality Unsplash placeholders based on category
        return match($this->category) {
            'artist' => "https://images.unsplash.com/photo-1493225255756-d9584f8606e9?w=800&q=80",
            'song' => "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&q=80",
            'genre' => "https://images.unsplash.com/photo-1514525253361-bee8a48740ad?w=800&q=80",
            default => "https://images.unsplash.com/photo-1459749411177-042180ce6742?w=800&q=80"
        };
    }

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

    public function term()
    {
        return $this->hasOne(Term::class);
    }

    public function analysis()
    {
        return $this->hasOne(ArticleAnalysis::class);
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

    public function getMetaDescriptionAttribute(): string
    {
        if ($this->analysis && $this->analysis->summary) {
            return $this->analysis->summary;
        }
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 160);
    }

    public function getMetaKeywordsAttribute(): string
    {
        $base = [$this->title, $this->category, 'ChaynWiki', 'music encyclopedia'];
        if ($this->analysis && !empty($this->analysis->themes)) {
            $base = array_merge($base, $this->analysis->themes);
        }
        return implode(', ', array_unique($base));
    }
}
