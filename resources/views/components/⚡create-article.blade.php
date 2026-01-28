<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Article;
use Illuminate\Support\Str;

new #[Layout('layouts.app')] class extends Component
{
    // Step 1: Category
    public $category = '';
    public $step = 1;

    // Step 2: Common Details
    public $title = '';
    public $content = '';
    
    // Song Specific
    public $song_release_date = '';
    public $song_duration_seconds = 0;
    public $song_lyrics = '';

    // Artist Specific
    public $artist_active_from = '';
    
    public function setCategory($category)
    {
        $this->category = $category;
        $this->step = 2;
    }

    public function goBack()
    {
        $this->step = 1;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        // Create Article
        $article = Article::create([
            'user_id' => auth()->id(),
            'category' => $this->category,
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . Str::random(6),
            'content' => $this->content,
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Create specific model based on category
        if ($this->category === 'song') {
            \App\Models\Song::create([
                'article_id' => $article->id,
                'title' => $this->title,
                'release_date' => $this->song_release_date ?: null,
                'lyrics' => $this->song_lyrics,
            ]);
        } elseif ($this->category === 'artist') {
            \App\Models\Artist::create([
                'article_id' => $article->id,
                'name' => $this->title, // Assuming artist name is title
                'active_from' => $this->artist_active_from ?: null,
            ]);
        } elseif ($this->category === 'genre') {
             \App\Models\Genre::create([
                'article_id' => $article->id,
                'name' => $this->title,
            ]);
        }

        // Award reputation (simulated)
        // app(ReputationService::class)->award(auth()->user(), 10, 'Created article');

        return $this->redirectRoute('wiki.show', ['article' => $article->slug], navigate: true);
    }
};
?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Step 1: Choose Category -->
        @if($step === 1)
        <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
            <div class="text-center space-y-4">
                <h1 class="text-4xl font-display font-bold text-white">What are you contributing?</h1>
                <p class="text-xl text-gray-400">Choose the type of page you want to create.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                {{-- Song --}}
                <button wire:click="setCategory('song')" class="group relative p-8 bg-white/5 border border-white/10 hover:bg-white/10 rounded-3xl text-left transition-all hover:scale-[1.02] hover:border-brand-500/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 rounded-3xl transition"></div>
                    <div class="relative space-y-4">
                        <div class="w-16 h-16 bg-brand-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-brand-500/20 group-hover:scale-110 transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2">Song</h3>
                            <p class="text-gray-400">Add lyrics, credits, and facts about a track.</p>
                        </div>
                    </div>
                </button>

                {{-- Artist --}}
                <button wire:click="setCategory('artist')" class="group relative p-8 bg-white/5 border border-white/10 hover:bg-white/10 rounded-3xl text-left transition-all hover:scale-[1.02] hover:border-purple-500/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 rounded-3xl transition"></div>
                    <div class="relative space-y-4">
                        <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-500/20 group-hover:scale-110 transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2">Artist</h3>
                            <p class="text-gray-400">Create a profile for a musician or band.</p>
                        </div>
                    </div>
                </button>

                {{-- Genre --}}
                <button wire:click="setCategory('genre')" class="group relative p-8 bg-white/5 border border-white/10 hover:bg-white/10 rounded-3xl text-left transition-all hover:scale-[1.02] hover:border-blue-500/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 rounded-3xl transition"></div>
                    <div class="relative space-y-4">
                        <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20 group-hover:scale-110 transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2">Genre</h3>
                            <p class="text-gray-400">Define a musical style or movement.</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
        @endif

        <!-- Step 2: Form -->
        @if($step === 2)
        <div class="max-w-3xl mx-auto space-y-6 animate-in fade-in slide-in-from-right-8 duration-500">
            <button wire:click="goBack" class="flex items-center text-gray-400 hover:text-white transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Category Selection
            </button>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-xl">
                <h2 class="text-3xl font-bold text-white mb-6">Create {{ ucfirst($category) }}</h2>
                
                <form wire:submit="save" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title / Name')" />
                        <x-text-input wire:model="title" id="title" class="block mt-1 w-full text-lg" placeholder="e.g. Bohemian Rhapsody" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Category Specific Fields -->
                    @if($category === 'song')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="song_release_date" :value="__('Release Date')" />
                                <x-text-input wire:model="song_release_date" id="song_release_date" type="date" class="block mt-1 w-full" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="song_lyrics" :value="__('Lyrics')" />
                            <textarea wire:model="song_lyrics" id="song_lyrics" rows="6" class="block mt-1 w-full bg-white/5 border-white/10 text-white rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500" placeholder="Is this the real life? Is this just fantasy?"></textarea>
                        </div>
                    @endif

                    @if($category === 'artist')
                         <div>
                            <x-input-label for="artist_active_from" :value="__('Active Since')" />
                            <x-text-input wire:model="artist_active_from" id="artist_active_from" type="date" class="block mt-1 w-full" />
                        </div>
                    @endif

                    <!-- Content -->
                    <div>
                        <x-input-label for="content" :value="__('Description / Biography')" />
                        <textarea wire:model="content" id="content" rows="10" class="block mt-1 w-full bg-white/5 border-white/10 text-white rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500" placeholder="Write about the {{ $category }}... Markdown supported." required></textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-primary-button class="px-8 py-3 text-lg">
                            {{ __('Publish Article') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>