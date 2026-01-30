<div class="min-h-screen bg-primary pt-32 pb-24" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    <div class="max-w-[800px] mx-auto px-8">
        
        <!-- Header -->
        <div class="mb-16">
            <nav class="flex items-center gap-2 text-[10px] font-black text-white/10 uppercase tracking-[0.2em] mb-8 px-1">
                <a href="{{ route('home') }}" class="hover:text-blue-500 transition-colors">Home</a>
                <span>/</span>
                <span class="text-blue-500/50">Initialize Archive Node</span>
            </nav>

            <h1 class="text-5xl lg:text-6xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                WHAT ARE YOU <span class="text-blue-500">ARCHIVING</span>?
            </h1>

            <p class="text-[11px] font-black text-white/20 uppercase tracking-[0.3em]">
                Select the record classification to begin the data entry sequence.
            </p>
        </div>

        <!-- Classification Selector -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 px-1">
            @foreach(['song', 'artist', 'genre', 'playlist'] as $cat)
            <button 
                wire:click="setCategory('{{ $cat }}')"
                class="flex flex-col items-center justify-center p-6 rounded-2xl border transition-all group {{ $category === $cat ? 'bg-blue-600 border-blue-600 shadow-xl shadow-blue-500/10' : 'bg-secondary border-white/5 hover:border-white/10' }}"
            >
                <div class="w-10 h-10 rounded-xl mb-3 flex items-center justify-center transition-all {{ $category === $cat ? 'bg-white/20 text-white' : 'bg-white/5 text-white/20 group-hover:bg-white/10 group-hover:text-white' }}">
                    @if($cat === 'song')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    @elseif($cat === 'artist')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @elseif($cat === 'genre')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    @endif
                </div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $category === $cat ? 'text-white' : 'text-white/20' }}">{{ $cat }}</span>
            </button>
            @endforeach
        </div>

        <!-- Form Node -->
        <div class="bg-secondary border border-white/5 rounded-2xl p-10 md:p-16 shadow-2xl relative overflow-hidden">
            <div wire:loading wire:target="setCategory" class="absolute inset-0 bg-secondary/80 backdrop-blur-sm z-20 flex items-center justify-center">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-10 h-10 border-4 border-blue-500/10 border-t-blue-500 rounded-full animate-spin"></div>
                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Applying Protocol...</span>
                </div>
            </div>

            <form wire:submit="save" class="space-y-8">
                @if($category)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-full">
                            <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Primary Title Identification</label>
                            <input 
                                wire:model="title" 
                                type="text" 
                                placeholder="Enter canonical record name"
                                class="w-full bg-[#050510] border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-white/10 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all font-bold text-lg"
                            >
                            @error('title') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        @if($category === 'song')
                            <div>
                                <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Origin Artist</label>
                                <input wire:model="meta.artist_name" type="text" placeholder="Artist Name" class="w-full bg-[#050510] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Release Timestamp</label>
                                <input wire:model="meta.release_date" type="text" placeholder="YYYY-MM-DD" class="w-full bg-[#050510] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all">
                            </div>
                        @elseif($category === 'artist')
                            <div>
                                <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Origin Region</label>
                                <input wire:model="meta.origin" type="text" placeholder="e.g. United Kingdom" class="w-full bg-[#050510] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Active Chronology</label>
                                <input wire:model="meta.active_years" type="text" placeholder="e.g. 2010 - Present" class="w-full bg-[#050510] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all">
                            </div>
                        @endif

                        <div class="col-span-full">
                            <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Comprehensive Data Payload</label>
                            <textarea 
                                wire:model="content" 
                                rows="8"
                                placeholder="Input detailed historical and analytical data here..."
                                class="w-full bg-[#050510] border border-white/10 rounded-2xl px-6 py-5 text-white/80 placeholder-white/10 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all leading-relaxed text-sm"
                            ></textarea>
                            @error('content') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-full">
                            <label class="block text-[11px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Visual Identification (Cover Art)</label>
                            <div class="border border-dashed border-white/10 rounded-2xl p-12 text-center hover:border-blue-500/40 transition-all cursor-pointer group/upload bg-[#050510] hover:bg-white/[0.02]">
                                @if ($featured_image)
                                    <img src="{{ $featured_image->temporaryUrl() }}" class="w-40 h-40 object-cover rounded-2xl mx-auto shadow-2xl">
                                @else
                                    <div class="text-white/20 group-hover/upload:text-blue-500 transition-colors">
                                        <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-[10px] font-black uppercase tracking-widest">Commit High-Resolution Artwork</p>
                                    </div>
                                @endif
                                <input wire:model="featured_image" type="file" class="hidden">
                            </div>
                        </div>
                    </div>

                    <!-- Action Registry -->
                    <div class="flex flex-wrap items-center gap-4 pt-8 border-t border-white/5">
                        <button type="button" class="px-6 py-3 bg-white/5 border border-white/5 rounded-xl text-[9px] font-black text-white/30 uppercase tracking-widest hover:bg-white/10 hover:text-white transition-all">
                            Save Local Draft
                        </button>
                        <button type="submit" class="flex-1 md:flex-none px-10 py-3 bg-blue-600 hover:bg-blue-500 text-white font-black text-[10px] uppercase tracking-[0.3em] rounded-xl transition-all shadow-xl shadow-blue-500/10 active:scale-95">
                            Commit to Global Archive
                        </button>
                    </div>
                @else
                    <!-- Initialization Prompt -->
                    <div class="text-center py-20 grayscale opacity-20 group">
                        <svg class="w-20 h-20 mx-auto mb-8 transition-all group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="text-xl font-black italic uppercase tracking-tighter text-white">READY FOR INPUT</h3>
                        <p class="text-[10px] font-black uppercase tracking-widest mt-2">Select a classification to unlock protocol</p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
