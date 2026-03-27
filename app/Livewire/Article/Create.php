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
    
    // Form Data
    public $category = '';
    public $title = '';
    public $content = '';
    public $tags = ''; // Comma-separated tags
    public $featured_image;
    public $wantlist_id; // For community request fulfillment
    
    // Meta Data (Dynamic based on category)
    public $meta = [];
    
    // Spotify Integration
    public $spotifyImportUrl = '';
    public $isFetchingSpotify = false;
    public $remoteImage = null; // URL from Spotify

    public function mount()
    {
        if (session()->has('draft')) {
            $draft = session('draft');
            $this->title = $draft['title'] ?? '';
            $this->category = $draft['category'] ?? '';
            $this->content = $draft['content'] ?? '';
            
            if (!empty($draft['tags']) && is_array($draft['tags'])) {
                $this->tags = implode(', ', $draft['tags']);
            }
            
            if ($this->category) {
                $this->step = 2;
            }

            $this->wantlist_id = $draft['wantlist_id'] ?? null;
        }
    }
    
    public $step = 1;
    
    // Validation Rules
    protected function rules()
    {
        $rules = [
            'category' => 'required|in:song,artist,genre,playlist,term,label',
            'title' => 'required|min:2|max:255',
            'content' => 'required|min:10',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|max:10240',
        ];
        
        return $rules;
    }

    public function setCategory($id)
    {
        $this->category = $id;
        $this->step = 2;
    }

    public function goBack()
    {
        $this->step = 1;
        $this->category = '';
    }

    public function importSpotify(SpotifyService $spotify)
    {
        $this->isFetchingSpotify = true;
        $this->resetErrorBag();
        
        try {
            $url = $this->spotifyImportUrl;
            $type = '';
            $id = '';
            
            // Parse URL
            if (Str::contains($url, 'open.spotify.com/')) {
                $path = parse_url($url, PHP_URL_PATH);
                $parts = explode('/', trim($path, '/'));
                // Expected: ['track', 'ID'] or ['artist', 'ID']
                $type = $parts[0] ?? '';
                $id = $parts[1] ?? '';
            } elseif (Str::startsWith($url, 'spotify:')) {
                $parts = explode(':', $url);
                $type = $parts[1] ?? '';
                $id = $parts[2] ?? '';
            }
            
            if (!$id || !$type) {
                $this->addError('spotifyImportUrl', 'Invalid Spotify URL. Use a Track or Artist link.');
                return;
            }

            if ($type === 'track') {
                $this->category = 'song';
                $track = $spotify->getTrack($id);
                $features = $spotify->getAudioFeatures($id);
                
                if ($track) {
                    $this->title = $track->name;
                    $this->meta['artist_name'] = collect($track->artists)->pluck('name')->implode(', ');
                    $this->meta['release_date'] = $track->album->release_date ?? null;
                    $this->meta['spotify_id'] = $id;

                    // Images
                    if (!empty($track->album->images)) {
                        $this->remoteImage = $track->album->images[0]->url;
                    }

                    // Genre from Artist
                    if (!empty($track->artists[0]->id)) {
                        $artist = $spotify->getArtist($track->artists[0]->id);
                        if ($artist && !empty($artist->genres)) {
                            $this->meta['genre'] = implode(', ', array_slice($artist->genres, 0, 3));
                        }
                    }

                    if ($features) {
                        $this->meta['bpm'] = $features['tempo'];
                        $this->meta['camelot_key'] = $features['camelot'];
                        $this->meta['energy'] = $features['energy'];
                    }
                    
                    // Basic Content Template
                    $this->content = "<h3>Overview</h3>\n<p><strong>{$this->title}</strong> is a song by <strong>{$this->meta['artist_name']}</strong>, released on {$this->meta['release_date']} as part of the album *{$track->album->name}*.</p>\n\n<h3>Production</h3>\n<p>The track features a tempo of {$this->meta['bpm']} BPM and is written in the key of {$this->meta['camelot_key']} ({$features['key']}).</p>";
                }
            } elseif ($type === 'artist') {
                $this->category = 'artist';
                $artist = $spotify->getArtist($id);
                
                if ($artist) {
                    $this->title = $artist->name;
                    $this->meta['genre'] = implode(', ', array_slice($artist->genres, 0, 5));
                    $this->meta['spotify_id'] = $id;
                    $this->meta['followers'] = $artist->followers->total ?? 0;
                    
                    if (!empty($artist->images)) {
                        $this->remoteImage = $artist->images[0]->url;
                    }

                    $this->content = "<h3>Biography</h3>\n<p><strong>{$artist->name}</strong> is a recording artist known for " . implode(', ', $artist->genres) . ".</p>";
                }
            } else {
                 $this->addError('spotifyImportUrl', 'Only Tracks and Artists are supported currently.');
                 return;
            }
            
            $this->step = 2; // Auto-advance

        } catch (\Exception $e) {
            $this->addError('spotifyImportUrl', 'Import failed: ' . $e->getMessage());
        } finally {
            $this->isFetchingSpotify = false;
        }
    }

    public function save(ArticleService $service)
    {
        $this->validate();

        // Handle Image
        $imagePath = null;
        if ($this->featured_image) {
            $imagePath = $this->featured_image->store('articles', 'public');
        } elseif ($this->remoteImage) {
            // Download remote image
            try {
                $contents = file_get_contents($this->remoteImage);
                $name = 'articles/' . Str::random(40) . '.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($name, $contents);
                $imagePath = $name;
            } catch (\Exception $e) {
                // Ignore download failure, just continue without image
            }
        }

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'content' => $this->content,
            'featured_image' => $imagePath,
        ];
        
        $tagsArray = array_map('trim', explode(',', $this->tags));
        $tagsArray = array_filter($tagsArray);

        $article = $service->createArticle($data, $this->meta, $tagsArray);

        // Fulfill Wantlist Request if applicable
        if ($this->wantlist_id) {
            $request = \App\Models\Wantlist::find($this->wantlist_id);
            if ($request) {
                $request->update(['status' => 'fulfilled']);
            }
        }

        // Redirect to the newly created article
        session()->flash('message', 'Article created successfully!');
        return redirect()->route('wiki.show', ['article' => $article->slug]);
    }

    public function render()
    {
        return view('livewire.article.create')
            ->layout('layouts.wiki');
    }
}
