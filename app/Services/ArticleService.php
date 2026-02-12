<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Revision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleService
{
    /**
     * Create a new article with its content-specific model.
     *
     * @param array $data Basic article data (title, category, content, etc.)
     * @param array $metaData Specific data for the category (e.g. lyrics for songs)
     * @return Article
     */
    public function createArticle(array $data, array $metaData = [], array $tags = []): Article
    {
        return DB::transaction(function () use ($data, $metaData, $tags) {
            // 1. Create the base Article
            $article = Article::create([
                'user_id' => auth()->id(), // Assuming authenticated user
                'category' => $data['category'],
                'title' => $data['title'],
                'slug' => $this->generateUniqueSlug($data['title']),
                'content' => $data['content'] ?? '',
                'excerpt' => $data['excerpt'] ?? '',
                'featured_image' => $data['featured_image'] ?? null,
                'status' => 'published', // Default to published for now, or 'draft'
                'published_at' => now(),
                'is_master' => $data['is_master'] ?? false,
                'master_id' => $data['master_id'] ?? null,
                'data_quality' => $data['data_quality'] ?? 50,
                'trust_score' => $data['trust_score'] ?? 0,
            ]);

            // 2. Create the specific content model
            $this->createSpecificContent($article, $data['category'], $metaData);

            // 3. Create initial Revision
            Revision::create([
                'article_id' => $article->id,
                'user_id' => auth()->id(),
                'content_snapshot' => array_merge($article->only(['title', 'category', 'content', 'excerpt', 'featured_image']), $metaData),
                'change_summary' => 'Initial creation',
            ]);

            // 4. Process Neural Tags
            if (!empty($tags)) {
                $this->processTags($article, $tags);
            }

            return $article;
        });
    }

    private function processTags(Article $article, array $tags)
    {
        foreach ($tags as $tag) {
            $type = 'similar_to';
            $tagName = $tag;

            // Pattern for credits: "Role: TargetName"
            if (preg_match('/^(.+?):\s*(.+)$/', $tag, $matches)) {
                $role = strtolower(trim($matches[1]));
                $tagName = trim($matches[2]);

                $type = match($role) {
                    'producer' => 'produced_by',
                    'label' => 'released_on',
                    'remixed by' => 'remixed_by',
                    'mastered by' => 'mastered_by',
                    'composer' => 'composed_by',
                    'songwriter' => 'written_by',
                    default => 'linked_to'
                };
            }

            // Find target article (case-insensitive)
            $target = Article::where('title', 'LIKE', $tagName)->first();
            
            if ($target && $target->id !== $article->id) {
                // Check if relationship already exists
                $exists = \App\Models\ArticleRelationship::where('source_id', $article->id)
                    ->where('target_id', $target->id)
                    ->where('type', $type)
                    ->exists();
                    
                if (!$exists) {
                    \App\Models\ArticleRelationship::create([
                        'source_id' => $article->id,
                        'target_id' => $target->id,
                        'type' => $type,
                        'strength' => 85, // Direct credits are stronger than similarity
                        'metadata' => ['origin' => 'neural_archival_tag'],
                    ]);
                }
            }
        }
    }

    /**
     * Update an existing article and record a revision.
     */
    public function updateArticle(Article $article, array $data, array $metaData = []): Article
    {
        return DB::transaction(function () use ($article, $data, $metaData) {
            // Snapshot before update
            $oldSnapshot = $article->load(['song', 'artist', 'genre', 'playlist', 'revisions'])->toArray();

            // Update Article
            $article->update([
                'title' => $data['title'] ?? $article->title,
                'content' => $data['content'] ?? $article->content,
                'excerpt' => $data['excerpt'] ?? $article->excerpt,
                'featured_image' => $data['featured_image'] ?? $article->featured_image,
                'is_master' => $data['is_master'] ?? $article->is_master,
                'master_id' => $data['master_id'] ?? $article->master_id,
                'data_quality' => $data['data_quality'] ?? $article->data_quality,
                'trust_score' => $data['trust_score'] ?? $article->trust_score,
                // Slug usually doesn't change to maintain SEO, unless explicitly requested
            ]);

            // Update Specific Content
            $this->updateSpecificContent($article, $article->category, $metaData);

            // Create Revision
            Revision::create([
                'article_id' => $article->id,
                'user_id' => auth()->id(),
                'content_snapshot' => array_merge($article->only(['title', 'category', 'content', 'excerpt', 'featured_image']), $metaData),
                'change_summary' => $data['change_summary'] ?? 'Updated article',
            ]);

            return $article->refresh();
        });
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    private function createSpecificContent(Article $article, string $category, array $data)
    {
        switch ($category) {
            case 'song':
                $article->song()->create([
                    'title' => $article->title,
                    'artist_id' => $data['artist_id'] ?? null,
                    'album' => $data['album'] ?? null,
                    'release_date' => $data['release_date'] ?? null,
                    'lyrics' => $data['lyrics'] ?? null,
                    'spotify_id' => $data['spotify_id'] ?? null,
                    'youtube_id' => $data['youtube_id'] ?? null,
                    'songwriter' => $data['songwriters'] ?? null,
                    'studio_recorded' => $data['studio_recorded'] ?? null,
                    'behind_the_song' => $data['behind_the_song'] ?? null,
                    'achievements' => $data['achievements'] ?? null,
                    'lyrics_snippet' => $data['lyrics_snippet'] ?? null,
                ]);
                break;
            case 'artist':
                $article->artist()->create([
                    'name' => $article->title,
                    'biography' => $data['biography'] ?? $article->content,
                    'spotify_id' => $data['spotify_id'] ?? null,
                    'active_years_string' => $data['active_years'] ?? null,
                    'top_songs_meta' => $data['top_songs'] ?? null,
                    'breakthrough_moment' => $data['breakthrough_moment'] ?? null,
                    'live_performances' => $data['live_performances'] ?? null,
                ]);
                break;
            case 'genre':
                $article->genre()->create([
                    'name' => $article->title,
                    'origin_country' => $data['origin_country'] ?? null,
                    'appearance_year' => $data['appearance_year'] ?? null,
                    'popular_artists' => $data['popular_artists'] ?? null,
                    'early_history' => $data['early_history'] ?? null,
                    'cultural_impact' => $data['cultural_impact'] ?? null,
                ]);
                break;
            case 'playlist':
                $article->playlist()->create([
                    'title' => $article->title,
                    'spotify_id' => $data['spotify_id'] ?? null,
                ]);
                break;
        }
    }

    private function updateSpecificContent(Article $article, string $category, array $data)
    {
        // Allowed keys for each relation
        $allowed = [
            'song' => [
                'artist_id', 'album', 'release_date', 'lyrics', 'spotify_id', 'youtube_id', 
                'bpm', 'key', 'songwriter', 'studio_recorded', 'behind_the_song', 
                'achievements', 'lyrics_snippet'
            ],
            'artist' => [
                'biography', 'spotify_id', 'website', 'social_links', 
                'active_years_string', 'top_songs_meta', 'breakthrough_moment', 'live_performances'
            ],
            'genre' => [
                'origin_country', 'appearance_year', 'popular_artists', 'early_history', 'cultural_impact'
            ],
            'playlist' => ['spotify_id'],
        ];

        $filteredData = array_intersect_key($data, array_flip($allowed[$category] ?? []));

        if (!empty($filteredData)) {
            $article->{$category}()->update($filteredData);
        }
    }
}
