<div class="min-h-screen bg-[#050511] py-12 pt-32 relative">
    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-brand-900/20 via-[#050511] to-[#050511]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.05]"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-600/20 text-brand-400 text-xs font-mono uppercase tracking-widest mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Contribution
        </div>
        <h1 class="text-4xl md:text-5xl font-display font-black text-white uppercase tracking-tight mb-4">Contribute to the Archive</h1>
        <p class="text-gray-400 max-w-xl mx-auto">Add knowledge to the definitive music encyclopedia.</p>
    </div>

    <!-- Progress Steps -->
    <div class="flex items-center justify-center mb-16">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $step >= 1 ? 'bg-brand-500 text-white shadow-[0_0_20px_rgba(59,130,246,0.5)] scale-110' : 'bg-white/5 text-gray-500 border border-white/10' }}">1</div>
            <span class="ml-3 text-sm font-bold uppercase tracking-wider {{ $step >= 1 ? 'text-white' : 'text-gray-600' }}">Category</span>
        </div>
        <div class="w-24 h-px mx-6 bg-gradient-to-r from-brand-500/50 to-purple-500/50 {{ $step >= 2 ? 'opacity-100' : 'opacity-20' }}"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $step >= 2 ? 'bg-brand-500 text-white shadow-[0_0_20px_rgba(59,130,246,0.5)] scale-110' : 'bg-white/5 text-gray-500 border border-white/10' }}">2</div>
            <span class="ml-3 text-sm font-bold uppercase tracking-wider {{ $step >= 2 ? 'text-white' : 'text-gray-600' }}">Details</span>
        </div>
    </div>

    <div class="bg-[#0A0A14] backdrop-blur-xl border border-white/10 rounded-[32px] p-8 md:p-12 relative overflow-hidden shadow-2xl">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/5 rounded-full blur-[100px] -mr-32 -mt-32 pointer-events-none"></div>

        <!-- Step 1: Category Selection -->
        @if ($step === 1)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
                <!-- Song -->
                <button wire:click="setCategory('song')" class="group relative p-6 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition text-left flex flex-col gap-4 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 via-blue-500/0 to-blue-500/10 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Song</h3>
                        <p class="text-xs text-gray-400">Single tracks, remixes, or instrumental pieces.</p>
                    </div>
                </button>

                <!-- Artist -->
                <button wire:click="setCategory('artist')" class="group relative p-6 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition text-left flex flex-col gap-4 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 via-purple-500/0 to-purple-500/10 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Artist</h3>
                        <p class="text-xs text-gray-400">Solo musicians, bands, or collectives.</p>
                    </div>
                </button>

                <!-- Genre -->
                 <button wire:click="setCategory('genre')" class="group relative p-6 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition text-left flex flex-col gap-4 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500/0 via-pink-500/0 to-pink-500/10 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center text-pink-400 group-hover:scale-110 transition">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Genre</h3>
                        <p class="text-xs text-gray-400">Musical styles, movements, or micro-genres.</p>
                    </div>
                </button>
            </div>
        @endif

        <!-- Step 2: Details Form -->
        @if ($step === 2)
            <div class="animate-fade-in-up">
                <div class="flex items-center justify-between mb-8">
                     <h2 class="text-2xl font-bold text-white capitalize">Add New {{ $category }}</h2>
                     <button wire:click="goBack" class="text-sm text-gray-400 hover:text-white underline">Change Category</button>
                </div>
                
                <!-- Spotify Import -->
                @if($category === 'song' || $category === 'artist')
                    <div class="mb-8 p-4 bg-[#81b71a]/10 border border-[#81b71a]/20 rounded-xl flex items-end gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-[#81b71a] uppercase tracking-wider mb-1">Auto-fill from Spotify</label>
                            <input wire:model="spotifyImportUrl" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg px-3 py-2 text-white text-sm focus:ring-1 focus:ring-[#81b71a] transition" placeholder="Paste Spotify Link (e.g. https://open.spotify.com/track/...)">
                            @error('spotifyImportUrl') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <button type="button" wire:click="fetchFromSpotify" wire:loading.attr="disabled" class="px-4 py-2 bg-[#81b71a] hover:bg-[#81b71a]/90 text-black font-bold text-sm rounded-lg transition flex items-center gap-2">
                            <svg wire:loading.remove wire:target="fetchFromSpotify" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.48.66.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.72 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                            <svg wire:loading wire:target="fetchFromSpotify" class="animate-spin w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span>Fetch Data</span>
                        </button>
                    </div>
                @endif

                <form wire:submit="save" class="space-y-6">
                    <!-- Basic Info -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Title / Name *</label>
                        <input wire:model="title" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition" placeholder="e.g. Midnight City">
                        @error('title') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description / Content -->
                    <div wire:ignore>
                        <label class="block text-sm font-medium text-gray-300 mb-2">{{ $category === 'song' ? 'Description / Context' : 'Biography' }} *</label>
                        
                        <div x-data="richText($wire.entangle('content'))" class="w-full bg-white/5 border border-white/10 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-brand-500 transition">
                            <!-- Toolbar -->
                            <div class="flex items-center gap-1 p-2 border-b border-white/5 bg-white/5">
                                <button type="button" @click="toggleBold()" :class="{ 'text-brand-400 bg-white/10': editor?.isActive('bold') }" class="p-1.5 rounded hover:bg-white/10 text-gray-400 transition" title="Bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 100-8H6v8zm0 0l4 8"></path></svg>
                                </button>
                                <button type="button" @click="toggleItalic()" :class="{ 'text-brand-400 bg-white/10': editor?.isActive('italic') }" class="p-1.5 rounded hover:bg-white/10 text-gray-400 transition" title="Italic">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4M6 16l-4-4 4-4M14 16l4 4 4-4m-4 4V8"></path></svg>
                                </button>
                                <div class="w-px h-4 bg-white/10 mx-1"></div>
                                <button type="button" @click="toggleH2()" :class="{ 'text-brand-400 bg-white/10': editor?.isActive('heading', { level: 2 }) }" class="p-1.5 rounded hover:bg-white/10 text-gray-400 transition font-bold text-xs">H2</button>
                                <button type="button" @click="toggleH3()" :class="{ 'text-brand-400 bg-white/10': editor?.isActive('heading', { level: 3 }) }" class="p-1.5 rounded hover:bg-white/10 text-gray-400 transition font-bold text-xs">H3</button>
                                <div class="w-px h-4 bg-white/10 mx-1"></div>
                                <button type="button" @click="toggleBulletList()" :class="{ 'text-brand-400 bg-white/10': editor?.isActive('bulletList') }" class="p-1.5 rounded hover:bg-white/10 text-gray-400 transition" title="List">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </button>
                            </div>

                            <!-- Editor Area -->
                            <div x-ref="editor" class="p-4 min-h-[300px] outline-none"></div>
                        </div>
                        @error('content') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                         <label class="block text-sm font-medium text-gray-300 mb-2">Featured Image</label>
                         <div class="flex items-center gap-4">
                            @if ($featured_image)
                                <img src="{{ $featured_image->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg">
                            @endif
                            <input wire:model="featured_image" type="file" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
                         </div>
                    </div>

                    <!-- Category Specific Fields -->
                    @if($category === 'song')
                        <div class="pt-6 border-t border-white/10">
                            <h3 class="text-lg font-bold text-white mb-4">Song Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Spotify ID (Optional)</label>
                                    <input wire:model="meta.spotify_id" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:ring-2 focus:ring-brand-500 transition" placeholder="Spotify Track ID">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Artist ID (Internal)</label>
                                    <input wire:model="meta.artist_id" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:ring-2 focus:ring-brand-500 transition" placeholder="Search for artist...">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Lyrics</label>
                                <textarea wire:model="meta.lyrics" rows="6" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:ring-2 focus:ring-brand-500 transition font-mono text-sm" placeholder="Paste lyrics here..."></textarea>
                            </div>
                        </div>
                    @endif

                    <div class="pt-8 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-full transition-all shadow-[0_0_20px_rgba(59,130,246,0.3)] hover:shadow-[0_0_30px_rgba(59,130,246,0.5)]">
                            Create Article
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
