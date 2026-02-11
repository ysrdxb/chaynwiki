<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crate extends Model
{
    protected $table = 'user_crates';

    protected $fillable = ['user_id', 'name', 'slug', 'description', 'color_accent', 'is_public', 'views_count'];

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

    public function followers()
    {
        return $this->morphMany(Follower::class, 'followable');
    }

    public function collaborators()
    {
        return $this->hasMany(CrateCollaborator::class);
    }

    public function isFollowedBy($user)
    {
        if (!$user) return false;
        return $this->followers()->where('user_id', $user->id)->exists();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($crate) {
            if (empty($crate->slug)) {
                $crate->slug = \Illuminate\Support\Str::slug($crate->name) . '-' . \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
            }
        });
    }
}
