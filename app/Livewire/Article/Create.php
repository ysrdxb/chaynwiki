<?php

namespace App\Livewire\Article;

use App\Services\ArticleService;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\SpotifyService;
use App\Services\YouTubeService;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Form Data
    public $category = '';
    public $title = '';
    public $content = '';
    public $featured_image;
    
    // Meta Data (Dynamic based on category)
    public $meta = [];
    
    // Spotify Integration
    public $spotifyImportUrl = '';
    public $isFetchingSpotify = false;

    // Validation Rules
    protected function rules()
    {
        $rules = [
            'category' => 'required|in:song,artist,genre,playlist,term',
            'title' => 'required|min:2|max:255',
            'content' => 'required|min:10',
            'featured_image' => 'nullable|image|max:10240',
        ];

        if ($this->step == 2) {
            if ($this->category == 'song') {
                $rules['meta.artist_name'] = 'required|string|min:2|max:255';
                $rules['meta.release_date'] = 'required|string|max:50';
                $rules['meta.genre'] = 'required|string|min:2|max:100';
                $rules['meta.spotify_id'] = 'nullable|string|max:255';
                $rules['meta.lyrics_snippet'] = 'nullable|string';
            }
            if ($this->category == 'artist') {
                $rules['meta.active_years'] = 'required|string|max:100';
                $rules['meta.genre'] = 'required|string|min:2|max:150';
                $rules['meta.top_songs'] = 'nullable|string|max:255';
            }
            if ($this->category == 'genre') {
                $rules['meta.origin_country'] = 'required|string|min:2|max:150';
                $rules['meta.appearance_year'] = 'required|string|max:50';
                $rules['meta.popular_artists'] = 'required|string|min:2|max:255';
                $rules['meta.subgenres'] = 'nullable|string|max:255';
            }
            if ($this->category == 'playlist') {
                $rules['meta.track_count'] = 'required|integer|min:1';
                $rules['meta.spotify_id'] = 'nullable|string|max:255';
            }
            if ($this->category == 'term') {
                $rules['meta.category_type'] = 'required|string|max:50';
                $rules['meta.phonetic'] = 'nullable|string|max:100';
                $rules['meta.origin_language'] = 'nullable|string|max:100';
            }
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'category.required' => 'Please select a category before submitting.',
            'title.required' => 'The title is required.',
            'title.min' => 'The title must be at least 2 characters.',
            'content.required' => 'The content/description is required.',
            'content.min' => 'The content must be at least 10 characters.',
            'meta.artist_name.required' => 'The artist name is required for songs.',
            'meta.release_date.required' => 'The release date is required.',
            'meta.genre.required' => 'The genre is required.',
            'meta.active_years.required' => 'Active years is required for artists.',
            'meta.origin_country.required' => 'Origin country is required for genres.',
            'meta.appearance_year.required' => 'First appearance year is required.',
            'meta.popular_artists.required' => 'Popular artists is required for genres.',
            'meta.track_count.required' => 'Track count is required for playlists.',
            'meta.track_count.integer' => 'Track count must be a number.',
            'meta.track_count.min' => 'Track count must be at least 1.',
            'meta.category_type.required' => 'Category type is required for terminology.',
        ];
    }

    public function fetchFromLink(\App\Services\DataIntelligenceService $intelligence)
    {
        $this->validate([
            'spotifyImportUrl' => 'required|url'
        ]);

        $this->isFetchingSpotify = true;

        try {
            $result = $intelligence->fetchFromLink($this->spotifyImportUrl);

            if (!$result['success']) {
                throw new \Exception($result['message']);
            }

            if ($this->category !== $result['category']) {
                throw new \Exception("The provided link is for a {$result['category']}, but you are creating a {$this->category}.");
            }

            // Map data
            $data = $result['data'];
            $this->title = $data['title'];
            
            if ($this->category === 'song') {
                $this->meta['spotify_id'] = $data['spotify_id'] ?? null;
                $this->meta['album'] = $data['album'] ?? null;
                $this->meta['release_date'] = $data['release_date'] ?? null;
                $this->meta['artist_name'] = $data['artist'] ?? null;
                
                // If youtube_id was fetched by service (currently not in service but we could add it)
                if (isset($data['youtube_id'])) {
                    $this->meta['youtube_id'] = $data['youtube_id'];
                }
            } elseif ($this->category === 'artist') {
                $this->meta['spotify_id'] = $data['spotify_id'] ?? null;
                $this->meta['genres'] = is_array($data['genres'] ?? null) ? implode(', ', $data['genres']) : ($data['genres'] ?? '');
            }

            session()->flash('message', 'Node data successfully established from source link!');
        } catch (\Exception $e) {
            $this->addError('spotifyImportUrl', $e->getMessage());
        }

        $this->isFetchingSpotify = false;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        $this->step = 2;
    }

    public function goBack()
    {
        $this->step--;
    }

    public function save(ArticleService $service)
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'content' => $this->content,
            'featured_image' => $this->featured_image ? $this->featured_image->store('articles', 'public') : null,
        ];

        $article = $service->createArticle($data, $this->meta);

        // Redirect to the newly created article
        // return redirect()->route('wiki.show', ['category' => $this->category, 'slug' => $article->slug]);
        session()->flash('message', 'Article created successfully!');
        return redirect()->to(route('dashboard')); // Temporary
    }

    public function render()
    {
        return view('livewire.article.create')
            ->layout('layouts.wiki');
    }
}
