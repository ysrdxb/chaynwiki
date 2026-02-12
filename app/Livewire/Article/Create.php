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

    public function save(ArticleService $service)
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'content' => $this->content,
            'featured_image' => $this->featured_image ? $this->featured_image->store('articles', 'public') : null,
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
