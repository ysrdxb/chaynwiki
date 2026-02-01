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
    <div class="h-full flex flex-col bg-[#0D0D1A] border border-white/5 rounded-2xl p-4 hover:border-blue-500/20 transition-all duration-500 shadow-xl group-hover:-translate-y-1">
        <!-- Image Area -->
        <div class="relative aspect-[16/10] rounded-xl overflow-hidden mb-5">
            <img
                src="{{ $featured_image }}"
                onerror="this.onerror=null;this.src='{{ $placeholder }}';"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                alt="{{ $article->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 via-transparent to-transparent"></div>
            
            <div class="absolute top-3 left-3">
                <span class="px-2 py-1 bg-blue-600 text-white text-[8px] font-black uppercase tracking-[0.2em] rounded-lg shadow-lg">
                    {{ $article->category }}
                </span>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col px-1">
            <h3 class="text-white font-black text-[15px] leading-tight mb-2 group-hover:text-blue-500 transition-colors line-clamp-2 italic uppercase tracking-tight">
                {{ $article->title }}
            </h3>
            
            <p class="text-slate-400 text-[10px] line-clamp-2 mb-6 font-black uppercase tracking-widest leading-loose italic">
                {{ Str::limit(strip_tags($article->content), 70) }}
            </p>

            <!-- Footer -->
            <div class="mt-auto pt-4 border-t border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-500/5 border border-blue-500/10 flex items-center justify-center">
                        <span class="text-[9px] font-black text-blue-500">{{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $article->user->name ?? 'GUEST' }}</span>
                </div>
                
                <div class="flex items-center gap-2 text-slate-400 group-hover:text-blue-500 transition-colors">
                    <span class="text-[8px] font-black uppercase tracking-[0.2em]">Access</span>
                    <div class="w-5 h-5 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <svg class="w-3 h-3 translate-x-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
