<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'content_snapshot',
        'change_summary',
    ];

    protected $casts = [
        'content_snapshot' => 'array',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
