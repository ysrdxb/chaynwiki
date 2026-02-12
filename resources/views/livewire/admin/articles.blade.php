<div class="space-y-10">
    
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-500 shadow-xl shadow-blue-500/5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <h2 class="text-[28px] font-black text-white uppercase tracking-tighter leading-none">Content Library</h2>
                <p class="text-white/40 text-[12px] font-bold uppercase tracking-widest mt-1.5">Manage global database encyclopedia</p>
            </div>
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
             <div class="relative group">
                <input type="text" wire:model.live="search" placeholder="Search database..." class="pl-12 pr-6 py-3.5 bg-[#161b22] border border-white/10 rounded-[18px] text-[13px] font-bold text-white placeholder-white/20 focus:outline-none focus:border-blue-500/50 focus:ring-0 transition-all w-64 group-hover:w-80 group-focus-within:w-80 shadow-2xl">
                <svg class="w-4 h-4 text-white/20 absolute left-4 top-1/2 -translate-y-1/2 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <div class="relative">
                <select wire:model.live="filterCategory" class="pl-6 pr-10 py-3.5 bg-[#161b22] border border-white/10 rounded-[18px] text-[11px] font-black uppercase tracking-widest text-white/60 focus:outline-none focus:border-blue-500/50 transition-all appearance-none cursor-pointer hover:bg-white/5 hover:text-white shadow-2xl">
                    <option value="">All Categories</option>
                    <option value="song">Songs</option>
                    <option value="artist">Artists</option>
                    <option value="genre">Genres</option>
                    <option value="playlist">Playlists</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-40">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <a href="{{ route('wiki.create') }}" class="px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-[18px] transition-all shadow-xl shadow-blue-600/20 flex items-center gap-3 hover:scale-105 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Deploy Entry
            </a>
        </div>
    </div>

    <!-- Actual Content -->
    <div class="bg-[#161b22] border border-white/5 rounded-[32px] overflow-hidden shadow-2xl relative">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Entry Profile</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Classification</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Provenance</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @foreach($articles as $article)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <!-- Entry Profile -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-5">
                                    <div class="relative w-14 h-14 rounded-2xl overflow-hidden border border-white/10 group-hover:border-blue-500/40 transition-all shadow-lg group-hover:shadow-blue-500/5">
                                        @if($article->featured_image)
                                            <img src="{{ Storage::url($article->featured_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-blue-600/10 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-500/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[15px] font-black text-white group-hover:text-blue-400 transition-colors truncate tracking-tight">{{ $article->title }}</div>
                                        <div class="text-[11px] text-white/30 font-bold mt-1 uppercase tracking-widest truncate">/{{ $article->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Classification -->
                            <td class="px-10 py-5">
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-white/5 bg-white/5 text-[10px] font-black uppercase tracking-widest text-white/60 group-hover:text-white transition-colors">
                                    <span class="w-2 h-2 rounded-full {{ $article->category === 'song' ? 'bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]' : ($article->category === 'artist' ? 'bg-purple-500 shadow-[0_0_8px_rgba(168,85,247,0.6)]' : 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]') }}"></span>
                                    {{ $article->category }}
                                </span>
                            </td>

                            <!-- Provenance -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-3 mb-1.5">
                                    <div class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-black text-white/60 uppercase">
                                        {{ substr($article->user->name ?? 'S', 0, 1) }}
                                    </div>
                                    <span class="text-[12px] font-bold text-white/60">{{ $article->user->name ?? 'System' }}</span>
                                </div>
                                <div class="text-[10px] text-white/20 font-black uppercase tracking-[0.2em]">{{ $article->created_at->format('M d, Y') }}</div>
                            </td>

                            <!-- Operations -->
                            <td class="px-10 py-5">
                                <div class="flex items-center justify-end gap-1.5 group-hover:translate-x-0 transition-transform">
                                    <button wire:click="toggleFeatured({{ $article->id }})" class="p-2.5 rounded-xl hover:bg-amber-500/10 hover:text-amber-500 border border-transparent hover:border-amber-500/20 transition-all {{ $article->is_featured ? 'text-amber-500 bg-amber-500/10 border-amber-500/20' : 'text-white/20' }}" title="Highlight Content">
                                        <svg class="w-4.5 h-4.5" fill="{{ $article->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    </button>
                                    
                                    <a href="{{ route('wiki.edit', $article->slug) }}" class="p-2.5 rounded-xl hover:bg-blue-500/10 hover:text-blue-500 border border-transparent hover:border-blue-500/20 transition-all text-white/20" title="Modify Index">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <button wire:click="deleteArticle({{ $article->id }})" wire:confirm="Are you sure you want to delete this record?" class="p-2.5 rounded-xl hover:bg-rose-500/10 hover:text-rose-500 border border-transparent hover:border-rose-500/20 transition-all text-white/20" title="Purge Record">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        <div class="px-10 py-6 border-t border-white/5 bg-white/[0.02]">
            {{ $articles->links() }}
        </div>
    </div>
</div>

