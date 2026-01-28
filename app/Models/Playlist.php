<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function tracks()
    {
        return $this->hasMany(PlaylistTrack::class)->orderBy('position');
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_tracks')->withPivot('position')->orderBy('playlist_tracks.position');
    }
}
