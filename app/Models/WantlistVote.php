<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WantlistVote extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wantlist()
    {
        return $this->belongsTo(Wantlist::class);
    }
}
