<?php

namespace App\Observers;

use App\Models\Article;
use App\Services\CacheService;

class ArticleObserver
{
    protected CacheService $cache;
    protected \App\Services\ReputationService $reputation;

    public function __construct(CacheService $cache, \App\Services\ReputationService $reputation)
    {
        $this->cache = $cache;
        $this->reputation = $reputation;
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        $this->cache->clearArticleCache();
        
        if ($article->user_id) {
            $this->reputation->award($article->user, \App\Services\ReputationService::POINTS_CREATE_ARTICLE, 'Created verified article: ' . $article->title);
        }
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
