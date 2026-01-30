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
                $rules['meta.artist_id'] = 'nullable'; // TODO: Validation
                $rules['meta.spotify_id'] = 'nullable';
                $rules['meta.lyrics'] = 'nullable';
            }
            if ($this->category == 'artist') {
                $rules['meta.biography'] = 'nullable';
            }
        }

        return $rules;
        return $rules;
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
        return redirect()->to('/dashboard'); // Temporary
    }

    public function render()
    {
        return view('livewire.article.create')
            ->layout('layouts.wiki');
    }
}
