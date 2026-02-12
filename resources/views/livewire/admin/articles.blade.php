<div class="space-y-8">
    
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            @section('header', 'Content Library')
            @section('subheader', 'Manage the global encyclopedia database.')
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
             <div class="relative group">
                <input type="text" wire:model.live="search" placeholder="Search database..." class="pl-10 pr-4 py-2.5 bg-[#161b22]/60 border border-white/10 rounded-xl text-sm text-white placeholder-white/20 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all w-64 group-hover:w-80 group-focus-within:w-80">
                <svg class="w-4 h-4 text-white/40 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <select wire:model.live="filterCategory" class="px-4 py-2.5 bg-[#161b22]/60 border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all appearance-none cursor-pointer hover:bg-white/5">
                <option value="">All Categories</option>
                <option value="song">Songs</option>
                <option value="artist">Artists</option>
                <option value="genre">Genres</option>
                <option value="playlist">Playlists</option>
            </select>

            <a href="{{ route('wiki.create') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Entry
            </a>
        </div>
    </div>

    <!-- Actual Content -->
    <div>
        <div class="bg-[#161b22]/60 backdrop-blur-xl border border-white/5 rounded-[24px] overflow-hidden shadow-2xl relative">
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 px-8 py-5 border-b border-white/5 bg-white/[0.02]">
                <div class="col-span-4 text-[10px] font-black text-white/40 uppercase tracking-widest">Entry Details</div>
                <div class="col-span-2 text-[10px] font-black text-white/40 uppercase tracking-widest">Category</div>
                <div class="col-span-3 text-[10px] font-black text-white/40 uppercase tracking-widest">Metadata</div>
                <div class="col-span-3 text-[10px] font-black text-white/40 uppercase tracking-widest text-right">Actions</div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-white/5">
                @foreach($articles as $article)
                    <div class="grid grid-cols-12 gap-4 px-8 py-4 items-center hover:bg-white/[0.02] transition-colors group">
                        
                        <!-- Entry Details -->
                        <div class="col-span-4 flex items-center gap-4">
                            <div class="relative w-12 h-12 rounded-xl overflow-hidden border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                @if($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-blue-600/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-[14px] font-bold text-white group-hover:text-blue-400 transition-colors truncate">{{ $article->title }}</div>
                                <div class="text-[10px] text-white/40 font-mono mt-0.5 truncate">/{{ $article->slug }}</div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-span-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-white/5 bg-white/5 text-[10px] font-bold uppercase tracking-wider text-white/60">
                                <span class="w-1.5 h-1.5 rounded-full {{ $article->category === 'song' ? 'bg-blue-500' : ($article->category === 'artist' ? 'bg-purple-500' : 'bg-emerald-500') }}"></span>
                                {{ $article->category }}
                            </span>
                        </div>

                        <!-- Metadata -->
                        <div class="col-span-3">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center text-[8px] font-bold text-white/60">
                                    {{ substr($article->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-[11px] text-white/60">{{ $article->user->name ?? 'System' }}</span>
                            </div>
                            <div class="text-[10px] text-white/30">{{ $article->created_at->format('M d, Y') }}</div>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-3 flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                            <button wire:click="toggleFeatured({{ $article->id }})" class="p-2 rounded-lg hover:bg-amber-500/10 hover:text-amber-500 transition-colors {{ $article->is_featured ? 'text-amber-500' : 'text-white/20' }}" title="Toggle Featured">
                                <svg class="w-4 h-4" fill="{{ $article->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </button>
                            
                            <a href="{{ route('wiki.edit', $article->slug) }}" class="p-2 rounded-lg hover:bg-blue-500/10 hover:text-blue-500 text-white/40 transition-colors" title="Edit Entry">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            <button wire:click="deleteArticle({{ $article->id }})" wire:confirm="Are you sure you want to delete this? This action cannot be undone." class="p-2 rounded-lg hover:bg-red-500/10 hover:text-red-500 text-white/40 transition-colors" title="Delete Entry">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer / Pagination -->
            <div class="px-8 py-4 border-t border-white/5 bg-white/[0.02]">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
