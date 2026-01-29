@php
    $hasRealImage = $article->featured_image && !str_contains($article->featured_image, 'placehold.co');
    $fallbacks = ['🎵', '🎤', '🎸', '🎹', '🎷', '🥁'];
    $fallbackIcon = $fallbacks[$loop->index % count($fallbacks)] ?? '🎵';
    $imagePath = $hasRealImage ? (str_starts_with($article->featured_image, 'http') ? $article->featured_image : Storage::url($article->featured_image)) : null;
@endphp

<a href="{{ route('wiki.show', $article->slug) }}" wire:navigate class="group block">
    <div class="relative rounded-2xl overflow-hidden bg-[#0a0a14] border border-white/5 hover:border-brand-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-brand-500/10 hover:-translate-y-2">
        <!-- Image or Icon Background -->
        <div class="relative aspect-[16/10] overflow-hidden">
            @if($imagePath)
                <img src="{{ $imagePath }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700" alt="{{ $article->title }}">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-brand-900/50 via-purple-900/30 to-[#0a0a14] flex items-center justify-center">
                    <span class="text-6xl opacity-30 group-hover:scale-110 transition-transform duration-500">{{ $fallbackIcon }}</span>
                </div>
            @endif
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a14] via-[#0a0a14]/60 to-transparent"></div>
            
            <!-- Category Badge -->
            <div class="absolute top-4 left-4">
                <span class="px-3 py-1.5 rounded-lg bg-black/50 backdrop-blur-sm border border-white/10 text-xs font-semibold text-brand-400 uppercase tracking-wider">
                    {{ $article->category }}
                </span>
            </div>
            
            <!-- View Count -->
            @if($article->view_count)
                <div class="absolute top-4 right-4 flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-black/50 backdrop-blur-sm border border-white/10 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($article->view_count) }}
                </div>
            @endif
        </div>
        
        <!-- Content -->
        <div class="p-6">
            <h3 class="text-lg font-display font-bold text-white mb-2 group-hover:text-brand-400 transition-colors line-clamp-2">
                {{ $article->title }}
            </h3>
            
            <p class="text-sm text-gray-500 line-clamp-2 mb-4">
                {{ Str::limit(strip_tags($article->content), 100) }}
            </p>
            
            <!-- Footer -->
            <div class="flex items-center justify-between pt-4 border-t border-white/5">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-brand-500/20 flex items-center justify-center text-brand-400 text-xs font-bold">
                        {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="text-xs text-gray-500">{{ $article->user->name ?? 'Anonymous' }}</span>
                </div>
                
                <div class="flex items-center gap-2 text-brand-400 text-xs font-semibold group-hover:gap-3 transition-all">
                    <span>Read</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Hover Glow -->
        <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 via-transparent to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
    </div>
</a>
