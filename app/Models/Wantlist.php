<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wantlist extends Model
{
    protected $table = 'knowledge_wantlist';
    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voterRelationships()
    {
        return $this->hasMany(WantlistVote::class);
    }

    public function voters()
    {
        return $this->belongsToMany(User::class, 'wantlist_votes');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }
}
