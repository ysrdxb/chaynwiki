<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrateArticle extends Model
{
    protected $fillable = ['crate_id', 'article_id', 'notes'];

    public function crate()
    {
        return $this->belongsTo(Crate::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
