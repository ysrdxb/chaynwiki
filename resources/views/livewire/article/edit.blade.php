    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[#050511]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03]"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 px-2">
            <h1 class="text-3xl md:text-5xl font-black text-white uppercase italic tracking-tighter leading-none mb-4">
                Modify Registry: <span class="text-blue-500">{{ $article->title }}</span>
            </h1>
            <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em]">
                Authorized revision sequence for {{ $article->category }} node
            </p>
        </div>

        <!-- Skeleton Loading State -->
        <div x-show="!loaded" class="bg-secondary border border-white/5 rounded-2xl p-8 md:p-12 space-y-10 shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @for($i = 0; $i < 2; $i++)
                <div class="space-y-4">
                    <div class="skeleton-v2 h-3 w-16"></div>
                    <div class="skeleton-v2 h-12 w-full rounded-xl"></div>
                </div>
                @endfor
            </div>
            <div class="space-y-4">
                <div class="skeleton-v2 h-3 w-24"></div>
                <div class="skeleton-v2 h-20 w-full rounded-xl"></div>
            </div>
            <div class="space-y-4">
                <div class="skeleton-v2 h-3 w-40"></div>
                <div class="skeleton-v2 h-48 w-full rounded-2xl"></div>
            </div>
        </div>

        <!-- Actual Form Content -->
        <form wire:submit.prevent="submit" x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8" style="display: none;">
            <!-- Form Grid -->
            <div class="bg-secondary border border-white/5 rounded-2xl p-8 md:p-12 space-y-10 shadow-2xl">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Title -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-mono font-bold text-white/40 uppercase tracking-[0.2em]">Title</label>
                        <input type="text" wire:model="title" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-gray-600 focus:border-brand-500/50 focus:ring-0 transition-all font-bold">
                        @error('title') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-mono font-bold text-white/40 uppercase tracking-[0.2em]">Category</label>
                        <select wire:model="category" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brand-500/50 focus:ring-0 transition-all font-bold appearance-none">
                            <option value="song">Song</option>
                            <option value="artist">Artist</option>
                            <option value="genre">Genre</option>
                            <option value="playlist">Playlist</option>
                            <option value="term">Term</option>
                        </select>
                        @error('category') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="space-y-3">
                    <label class="text-[10px] font-mono font-bold text-white/40 uppercase tracking-[0.2em]">Quick Summary</label>
                    <textarea wire:model="excerpt" rows="2" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-gray-600 focus:border-brand-500/50 focus:ring-0 transition-all font-medium"></textarea>
                    @error('excerpt') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <!-- Content -->
                <div class="space-y-3">
                    <label class="text-[10px] font-mono font-bold text-white/40 uppercase tracking-[0.2em]">Main Content (Markdown supported)</label>
                    <textarea wire:model="content" rows="12" class="w-full bg-white/5 border border-white/10 rounded-3xl px-6 py-4 text-white placeholder-gray-600 focus:border-brand-500/50 focus:ring-0 transition-all font-medium leading-relaxed"></textarea>
                    @error('content') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <!-- Featured Image -->
                <div class="space-y-4">
                    <label class="text-[10px] font-mono font-bold text-white/40 uppercase tracking-[0.2em]">Featured Image</label>
                    <div class="relative group cursor-pointer">
                        <input type="file" wire:model="featured_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="bg-white/5 border-2 border-dashed border-white/10 rounded-3xl p-12 text-center group-hover:border-brand-500/30 transition-all">
                            @if ($featured_image)
                                <img src="{{ $featured_image->temporaryUrl() }}" class="max-h-40 mx-auto rounded-xl">
                            @else
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-bold uppercase tracking-widest">Upload New Cover</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @error('featured_image') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="pt-10 border-t border-white/5">
                    <!-- Change Summary -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-mono font-bold text-brand-400 uppercase tracking-[0.2em]">What did you change? (Required)</label>
                        <input type="text" wire:model="change_summary" placeholder="e.g. Fixed typo in lyrics, updated discography..." class="w-full bg-brand-500/5 border border-brand-500/20 rounded-2xl px-6 py-4 text-white placeholder-gray-600 focus:border-brand-500/50 focus:ring-0 transition-all font-bold">
                        @error('change_summary') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between gap-6 pt-6">
                    <a href="{{ route('wiki.show', $article->slug) }}" class="text-[9px] font-black text-white/20 uppercase tracking-widest hover:text-white transition-all underline decoration-white/5 underline-offset-8">Abort Sequence</a>
                    <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 text-white rounded-xl px-10 py-4 font-black text-[10px] uppercase tracking-widest hover:bg-blue-500 transition-all shadow-xl shadow-blue-500/10 flex items-center gap-4">
                        <span wire:loading.remove>Commit Revision</span>
                        <span wire:loading>Processing...</span>
                        <div class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
