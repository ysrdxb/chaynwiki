<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    // Fallback username for now until migration adds one
    public function getUsernameAttribute()
    {
        return \Illuminate\Support\Str::slug($this->name);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'reputation_score',
        'avatar',
        'bio',
        'location',
        'website',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function getLevelAttribute(): int
    {
        return floor($this->reputation_score / 100) + 1;
    }

    public function getRankNameAttribute(): string
    {
        return match (true) {
            $this->reputation_score >= 1000 => 'High Guardian',
            $this->reputation_score >= 500 => 'Expert Contributor',
            $this->reputation_score >= 200 => 'Recognized Member',
            $this->reputation_score >= 100 => 'Active Contributor',
            default => 'Novice',
        };
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }
}
