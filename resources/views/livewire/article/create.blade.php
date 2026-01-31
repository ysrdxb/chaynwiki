<div class="min-h-screen bg-[#050510] pt-24 pb-12" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    <style>
        .bg-custom-9 {
            background-color: rgb(255 255 255 / 9%) !important;
        }
        .border-custom-35 {
            border-color: rgb(255 255 255 / 35%) !important;
        }
    </style>

    <div class="max-w-[1240px] mx-auto px-8">
        
        <!-- Header -->
        <div class="mb-12">
            <span class="text-white/40 text-sm font-medium mb-3 block">Select Type</span>
            <h1 class="text-[52px] font-black text-white uppercase tracking-tight leading-none mb-4">
                WHAT ARE YOU ADDING?
            </h1>
            <p class="text-white/40 text-sm">Choose one content type — fields will adapt automatically.</p>
        </div>

        <!-- Category Selector Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-16">
            @foreach([
                ['id' => 'song', 'title' => 'Song', 'desc' => 'Add a single track, lyrics, credits, streaming links', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                ['id' => 'artist', 'title' => 'Artist', 'desc' => 'Create or update an artist profile and discography', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['id' => 'genre', 'title' => 'Genre', 'desc' => 'Define a genre: origin, key artists, characteristics', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
                ['id' => 'playlist', 'title' => 'Playlist', 'desc' => 'Create a public playlist with ordered tracks', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['id' => 'term', 'title' => 'Terminology', 'desc' => 'Define music theory, equipment, or industry terms', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253']
            ] as $cat)
            <button wire:click="setCategory('{{ $cat['id'] }}')" 
                class="flex flex-col p-8 rounded-[24px] transition-all text-left group relative {{ $category === $cat['id'] ? 'bg-white/5 border border-white/10' : 'bg-white/[0.02] border border-custom-35 hover:border-white/10' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-6 h-6 rounded bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 {{ $category === $cat['id'] ? 'text-blue-500' : 'text-white/20' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $cat['icon'] }}"/></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">{{ $cat['title'] }}</h3>
                <p class="text-xs text-white/20 leading-relaxed">{{ $cat['desc'] }}</p>
            </button>
            @endforeach
        </div>

        <form wire:submit="save" class="space-y-12">
            @if($category)
                {{-- Form Fields Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    
                    @if($category === 'song')
                        {{-- Song Fields --}}
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Add Title</label>
                            <input wire:model="title" type="text" placeholder="e.g. Evolution of Synthwave in Modern Pop" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Artist</label>
                            <input wire:model="meta.artist_name" type="text" placeholder="e.g. 'Wiz'" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Release Date</label>
                            <input wire:model="meta.release_date" type="text" placeholder="e.g. Evolution of Synthwave in Modern Pop" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Genre</label>
                            <div class="relative">
                                <select wire:model="meta.genre" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm focus:border-white/20 appearance-none outline-none">
                                    <option value="">Hip hop</option>
                                    <option value="pop">Pop</option>
                                    <option value="rock">Rock</option>
                                </select>
                                <svg class="w-4 h-4 text-white/40 absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Songwriters</label>
                            <input wire:model="meta.songwriters" type="text" placeholder="e.g. Evolution of Synthwave in Modern Pop" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Studio Recorded</label>
                            <input wire:model="meta.studio_recorded" type="text" placeholder="e.g. 'Wiz'" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        
                        {{-- Textareas --}}
                        <div class="col-span-full space-y-2 pt-4">
                            <label class="text-white text-sm font-bold block mb-1">Behind the Song</label>
                            <textarea wire:model="meta.behind_the_song" rows="4" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Achievements</label>
                            <textarea wire:model="meta.achievements" rows="4" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Overview</label>
                            <textarea wire:model="content" rows="6" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Lyrics snippet</label>
                            <textarea wire:model="meta.lyrics_snippet" rows="6" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>

                    @elseif($category === 'artist')
                        {{-- Artist Fields --}}
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Full Name</label>
                            <input wire:model="title" type="text" placeholder="e.g. Evolution of Synthwave in Modern Pop" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Active Years</label>
                            <input wire:model="meta.active_years" type="text" placeholder="e.g. 'Wiz'" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Genres</label>
                            <div class="relative">
                                <select wire:model="meta.genre" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm focus:border-white/20 appearance-none outline-none">
                                    <option value="">Hip hop</option>
                                </select>
                                <svg class="w-4 h-4 text-white/40 absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Top Songs</label>
                            <div class="relative">
                                <select wire:model="meta.top_songs" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm focus:border-white/20 appearance-none outline-none">
                                    <option value="">Hip hop</option>
                                </select>
                                <svg class="w-4 h-4 text-blue-500 absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l2.4 7.2h7.6l-6.1 4.5 2.3 7.3-6.2-4.5-6.2 4.5 2.3-7.3-6.1-4.5h7.6z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="col-span-full space-y-2 pt-4">
                            <label class="text-white text-sm font-bold block mb-1">Bio</label>
                            <textarea wire:model="content" rows="8" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Breakthrough Moment</label>
                            <textarea wire:model="meta.breakthrough_moment" rows="4" placeholder="Released debut album at age 18, which became a commercial hit and earned critical acclaim." class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Live Performances</label>
                            <textarea wire:model="meta.live_performances" rows="4" placeholder="World Tour 2015, Summer Live Festival 2017, International Arena Tour 2019" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>

                    @elseif($category === 'genre')
                        {{-- Genre Fields --}}
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Origin Country</label>
                            <input wire:model="meta.origin_country" type="text" placeholder="e.g. Evolution of Synthwave in Modern Pop" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">First Appearance Year</label>
                            <input wire:model="meta.appearance_year" type="text" placeholder="e.g. 'Wiz'" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Popular Artists</label>
                            <input wire:model="meta.popular_artists" type="text" placeholder="e.g. Evolution of Synthwave in Modern Pop" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Subgenres</label>
                            <div class="relative">
                                <select wire:model="meta.subgenres" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm focus:border-white/20 appearance-none outline-none">
                                    <option value="">Hip-Hop</option>
                                </select>
                                <svg class="w-4 h-4 text-white/40 absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>

                        <div class="col-span-full space-y-2 pt-4">
                            <label class="text-white text-sm font-bold block mb-1">Early History</label>
                            <textarea wire:model="meta.early_history" rows="4" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Cultural Impact</label>
                            <textarea wire:model="meta.cultural_impact" rows="4" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Description</label>
                            <textarea wire:model="content" rows="8" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                    @elseif($category === 'playlist')
                        {{-- Playlist Fields --}}
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Playlist Title</label>
                            <input wire:model="title" type="text" placeholder="e.g. Summer Vibes 2026" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Spotify ID / Link</label>
                            <input wire:model="meta.spotify_id" type="text" placeholder="e.g. spotify:playlist:..." class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Track Count</label>
                            <input wire:model="meta.track_count" type="number" placeholder="e.g. 25" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="col-span-full space-y-2 pt-4">
                            <label class="text-white text-sm font-bold block mb-1">Curator Note</label>
                            <textarea wire:model="meta.curator_note" rows="4" placeholder="Why should people listen to this?" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                        <div class="col-span-full space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Extended Description</label>
                            <textarea wire:model="content" rows="6" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                    @elseif($category === 'term')
                        {{-- Terminology Fields --}}
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Term Name</label>
                            <input wire:model="title" type="text" placeholder="e.g. Reverb" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Category Type</label>
                            <div class="relative">
                                <select wire:model="meta.category_type" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm focus:border-white/20 appearance-none outline-none">
                                    <option value="theory">Music Theory</option>
                                    <option value="equipment">Equipment & Gear</option>
                                    <option value="industry">Industry Terms</option>
                                    <option value="culture">Music Culture</option>
                                </select>
                                <svg class="w-4 h-4 text-white/40 absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Phonetic Pronunciation</label>
                            <input wire:model="meta.phonetic" type="text" placeholder="e.g. /rɪˈvɜːb/" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-white text-sm font-bold block mb-1">Origin Language</label>
                            <input wire:model="meta.origin_language" type="text" placeholder="e.g. Latin" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-4 text-white text-sm placeholder:text-white/10 focus:border-white/20 transition-all outline-none">
                        </div>
                        <div class="col-span-full space-y-2 pt-4">
                            <label class="text-white text-sm font-bold block mb-1">Definition & Usage</label>
                            <textarea wire:model="content" rows="8" placeholder="Type here" class="w-full bg-custom-9 border border-custom-35 rounded-xl px-6 py-5 text-white text-sm placeholder:text-white/10 focus:border-white/20 outline-none resize-none"></textarea>
                        </div>
                    @endif

                    {{-- Upload Zone --}}
                    <div class="col-span-full pt-8">
                        <label class="text-white text-sm font-bold block mb-4">Upload Cover Art</label>
                        <div class="relative group cursor-pointer">
                            <input wire:model="featured_image" type="file" class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer">
                            <div class="w-full bg-white/[0.02] border border-custom-35 border-dashed rounded-[20px] py-16 flex flex-col items-center justify-center transition-all group-hover:border-white/10 group-hover:bg-white/[0.04]">
                                @if ($featured_image)
                                    <img src="{{ $featured_image->temporaryUrl() }}" class="w-48 h-48 object-cover rounded-xl mb-4">
                                @else
                                    <div class="w-12 h-12 mb-4">
                                        <svg class="w-full h-full text-white/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <path d="M21 15l-5-5L5 21"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs text-white/40 font-medium">Upload Or Drag Here</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Pillar Buttons --}}
                <div class="flex items-center gap-4 pt-12 pb-20">
                    <button type="button" class="bg-white text-[#050510] font-bold text-sm px-8 py-3.5 rounded-full flex items-center gap-3 transition-transform hover:scale-105">
                        Save Draft
                        <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                        </div>
                    </button>
                    <button type="button" class="bg-white text-[#050510] font-bold text-sm px-8 py-3.5 rounded-full flex items-center gap-3 transition-transform hover:scale-105">
                        Preview
                        <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                        </div>
                    </button>
                    <button type="submit" class="bg-white text-[#050510] font-bold text-sm px-8 py-3.5 rounded-full flex items-center gap-3 transition-transform hover:scale-105">
                        Submit Review
                        <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                        </div>
                    </button>
                </div>

            @else
                {{-- Initialization Prompt --}}
                <div class="py-32 flex flex-col items-center justify-center text-center opacity-40 select-none">
                    <svg class="w-24 h-24 text-white/10 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.5"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <h3 class="text-3xl font-black italic uppercase tracking-tighter text-white mb-2">System Ready</h3>
                    <p class="text-sm text-white/20">Select a classification protocol to unlock data entry fields.</p>
                </div>
            @endif
        </form>
    </div>
</div>
