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
                'content_snapshot' => json_encode(array_merge($article->toArray(), $metaData)),
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
                'content_snapshot' => json_encode(array_merge($article->toArray(), $metaData)),
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
                    'title' => $article->title, // Redundant but useful for standalone query
                    'artist_id' => $data['artist_id'] ?? null, // Need to handle this
                    'album' => $data['album'] ?? null,
                    'release_date' => $data['release_date'] ?? null,
                    'lyrics' => $data['lyrics'] ?? null,
                    // Add other fields as per schema
                ]);
                break;
            case 'artist':
                $article->artist()->create([
                    'name' => $article->title,
                    'biography' => $data['biography'] ?? $article->content, // Fallback
                    // Add other fields
                ]);
                break;
            case 'genre':
                $article->genre()->create([
                    'name' => $article->title,
                    // 'description' is not in the genre table, we rely on article content
                ]);
                break;
             case 'playlist':
                $article->playlist()->create([
                    'title' => $article->title,
                    // 'description' is in article content
                ]);
                break;
        }
    }

    private function updateSpecificContent(Article $article, string $category, array $data)
    {
        // Similar switch to update the relation
        switch ($category) {
            case 'song':
                $article->song()->update($data); // Naive update, filter keys in real app
                break;
            case 'artist':
                $article->artist()->update($data);
                break;
             case 'genre':
                $article->genre()->update($data);
                break;
             case 'playlist':
                $article->playlist()->update($data);
                break;
        }
    }
}
