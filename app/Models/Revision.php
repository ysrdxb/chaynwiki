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
        'status',
        'moderated_by',
        'moderated_at',
    ];

    protected $casts = [
        'content_snapshot' => 'array',
        'moderated_at' => 'datetime',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }
}
