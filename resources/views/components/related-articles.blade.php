@props(['article', 'limit' => 4])

@php
    $related = \App\Models\Article::where('id', '!=', $article->id)
        ->where('status', 'published')
        ->where(function($q) use ($article) {
            $q->where('category', $article->category)
              ->orWhereRaw("MATCH(title, content) AGAINST(? IN NATURAL LANGUAGE MODE)", [$article->title]);
        })
        ->limit($limit)
        ->get();
@endphp

@if($related->count() > 0)
    <div class="border-t border-white/10 pt-12 mt-12">
        <h2 class="text-xl font-display font-bold text-white mb-6">Related Articles</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($related as $item)
                <a href="{{ route('wiki.show', $item) }}" class="group bg-[#0A0A14] border border-white/10 rounded-xl p-4 hover:border-brand-500/50 hover:bg-brand-500/5 transition-all">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/20 flex items-center justify-center text-brand-400 text-lg flex-shrink-0">
                            @switch($item->category)
                                @case('artist') 🎤 @break
                                @case('song') 🎵 @break
                                @case('genre') 🎸 @break
                                @default 📄
                            @endswitch
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-white font-semibold group-hover:text-brand-400 transition-colors truncate">
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-500 text-xs capitalize">{{ $item->category }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
