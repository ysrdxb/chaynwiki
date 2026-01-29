<?php

namespace App\Observers;

use App\Models\Article;
use App\Services\CacheService;

class ArticleObserver
{
    protected CacheService $cache;

    public function __construct(CacheService $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        $this->cache->clearArticleCache();
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        $this->cache->clearArticleCache($article->id);
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        $this->cache->clearArticleCache();
    }
}
