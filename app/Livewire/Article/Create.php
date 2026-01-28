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

    public function fetchFromSpotify(SpotifyService $spotify, YouTubeService $youtube)
    {
        $this->validate([
            'spotifyImportUrl' => 'required|url'
        ]);

        $this->isFetchingSpotify = true;

        try {
            // Extract ID from URL (e.g. https://open.spotify.com/track/123456?si=...)
            $url = $this->spotifyImportUrl;
            $id = basename(parse_url($url, PHP_URL_PATH));

            if ($this->category === 'song') {
                $track = $spotify->getTrack($id);
                
                $this->title = $track->name;
                $this->meta['spotify_id'] = $track->id;
                $this->meta['album'] = $track->album->name;
                $this->meta['release_date'] = $track->album->release_date;
                $this->meta['artist_id'] = $track->artists[0]->name; // Temporary string for now
                
                // Fetch YouTube Video
                $query = $track->artists[0]->name . ' - ' . $track->name . ' Official Video';
                $video = $youtube->searchVideo($query);
                if ($video) {
                    $this->meta['youtube_id'] = $video['id'];
                }
                
                // Try to get image
                if (!empty($track->album->images)) {
                    // In a real app we would download `track->album->images[0]->url` to temp storage
                }
                
                $msg = 'Spotify data imported!';
                if ($video) $msg .= ' YouTube video found.';
                session()->flash('message', $msg);
            }
        } catch (\Exception $e) {
            $this->addError('spotifyImportUrl', 'Failed to fetch data: ' . $e->getMessage());
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
        return view('livewire.article.create');
    }
}
