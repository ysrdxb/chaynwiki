<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $guarded = [];

    protected $casts = [
        'release_date' => 'date',
        'last_stream_update' => 'datetime',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Genetic Mapping Helpers
     */

    public function samples()
    {
        return $this->article->outgoingRelationships()
            ->where('type', 'samples')
            ->with(['target.song', 'target.artist']);
    }

    public function sampledBy()
    {
        return $this->article->incomingRelationships()
            ->where('type', 'samples')
            ->with(['source.song', 'source.artist']);
    }

    public function covers()
    {
        return $this->article->outgoingRelationships()
            ->where('type', 'covers')
            ->with(['target.song', 'target.artist']);
    }

    public function coveredBy()
    {
        return $this->article->incomingRelationships()
            ->where('type', 'covers')
            ->with(['source.song', 'source.artist']);
    }

    public function remixes()
    {
        return $this->article->incomingRelationships()
            ->where('type', 'remix_of')
            ->with(['source.song', 'source.artist']);
    }
}
