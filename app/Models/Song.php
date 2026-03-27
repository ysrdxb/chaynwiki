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
    /**
     * Get compatible Camelot keys for mixing
     * Returns: Same Key, Relative Minor/Major, +1 Semitone, -1 Semitone
     */
    public function getCompatibleKeysAttribute(): array
    {
        if (!$this->camelot_key) {
            return [];
        }

        $key = strtoupper($this->camelot_key);
        $number = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);
        $letter = preg_replace('/[^A-B]/', '', $key); // A or B

        if (!$number || !$letter) {
            return [];
        }

        $compatible = [];

        // 1. Same Key (e.g. 8A -> 8A)
        $compatible[] = $number . $letter;

        // 2. Relative Major/Minor (e.g. 8A -> 8B)
        $relativeLetter = ($letter === 'A') ? 'B' : 'A';
        $compatible[] = $number . $relativeLetter;

        // 3. Perfect Fifth Up (+1 Number) (e.g. 8A -> 9A)
        $nextNum = $number + 1;
        if ($nextNum > 12) $nextNum = 1;
        $compatible[] = $nextNum . $letter;

        // 4. Perfect Fifth Down (-1 Number) (e.g. 8A -> 7A)
        $prevNum = $number - 1;
        if ($prevNum < 1) $prevNum = 12;
        $compatible[] = $prevNum . $letter;

        // Extras: Energy Boost (+2) - Optional, but sticking to core harmonic mixing first
        
        return $compatible;
    }
}
