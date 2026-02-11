<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrateCollaborator extends Model
{
    protected $guarded = [];

    public function crate()
    {
        return $this->belongsTo(Crate::class, 'crate_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
