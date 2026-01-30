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
    public function createArticle(array $data, array $metaData = []): Article
    {
        return DB::transaction(function () use ($data, $metaData) {
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

            return $article;
        });
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
                ]);
                break;
            case 'artist':
                $article->artist()->create([
                    'name' => $article->title,
                    'biography' => $data['biography'] ?? $article->content,
                    'spotify_id' => $data['spotify_id'] ?? null,
                ]);
                break;
            case 'genre':
                $article->genre()->create([
                    'name' => $article->title,
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
            'song' => ['artist_id', 'album', 'release_date', 'lyrics', 'spotify_id', 'youtube_id', 'bpm', 'key'],
            'artist' => ['biography', 'spotify_id', 'website', 'social_links'],
            'genre' => [],
            'playlist' => ['spotify_id'],
        ];

        $filteredData = array_intersect_key($data, array_flip($allowed[$category] ?? []));

        if (!empty($filteredData)) {
            $article->{$category}()->update($filteredData);
        }
    }
}
