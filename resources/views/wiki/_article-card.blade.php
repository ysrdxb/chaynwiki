@php
    $placeholder = match ($article->category) {
        'artist' => 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=400',
        'song' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=400',
        'genre' => 'https://images.unsplash.com/photo-1514525253361-bee8a48740ad?auto=format&fit=crop&q=80&w=400',
        'playlist' => 'https://images.unsplash.com/photo-1459749411177-042180ce6742?auto=format&fit=crop&q=80&w=400',
        'term' => 'https://images.unsplash.com/photo-1514320299584-4bd06b02a04e?auto=format&fit=crop&q=80&w=400',
        default => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=400',
    };

    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    $featured_image = $featured_image ?: $placeholder;
@endphp

<a href="{{ route('wiki.show', $article->slug) }}" class="group block h-full">
    <div class="h-full flex flex-col card-premium-unified !p-0 border border-white/5 hover:border-blue-500/30 transition-all duration-500 shadow-3xl bg-[#161b22]/40 backdrop-blur-sm">
        <!-- Image Area -->
        <div class="relative aspect-[16/10] overflow-hidden group/img">
            <img
                src="{{ $featured_image }}"
                onerror="this.onerror=null;this.src='{{ $placeholder }}';"
                class="w-full h-full object-cover grayscale-[0.5] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000"
                alt="{{ $article->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-transparent to-transparent opacity-80"></div>
            
            <div class="absolute top-4 left-4">
                <span class="px-3 py-1 bg-blue-500 text-[#0d1117] text-[9px] font-black uppercase tracking-[0.2em] rounded-lg shadow-2xl">
                    {{ $article->category }}
                </span>
            </div>

            <div class="absolute inset-0 bg-blue-500/10 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                 <div class="w-12 h-12 rounded-full bg-white text-navy-900 flex items-center justify-center scale-75 opacity-0 group-hover/img:scale-100 group-hover/img:opacity-100 transition-all duration-500 shadow-2xl">
                     <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                 </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col p-6">
            <h3 class="text-white font-black text-[18px] leading-[1.1] mb-3 group-hover:text-blue-500 transition-colors line-clamp-2 tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                {{ $article->title }}
            </h3>
            
            <p class="text-white/30 text-[11px] line-clamp-2 mb-8 font-black tracking-tightest leading-relaxed">
                {{ Str::limit(strip_tags($article->content), 60) }}
            </p>

            <!-- Footer -->
            <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                        <span class="text-[10px] font-black text-blue-500">{{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black text-white/20 uppercase tracking-[0.2em] leading-none mb-1">Archivist</span>
                        <span class="text-[11px] font-black text-white/50 uppercase tracking-tight leading-none truncate max-w-[80px]">{{ $article->user->name ?? 'GUEST' }}</span>
                    </div>
                </div>
                
                <div class="group/btn flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/20 group-hover:bg-white group-hover:text-navy-900 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
