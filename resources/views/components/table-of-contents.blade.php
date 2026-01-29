@props(['content'])

@php
    // Extract headings from content for TOC
    preg_match_all('/<h([2-4])[^>]*>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER);
    
    $headings = collect($matches)->map(function($match, $index) {
        return [
            'level' => (int) $match[1],
            'text' => strip_tags($match[2]),
            'id' => 'heading-' . ($index + 1),
        ];
    });
@endphp

<div class="sticky top-24 bg-[#0A0A14]/80 backdrop-blur-md border border-white/10 rounded-2xl p-6" x-data="{ activeId: '' }">
    <h3 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">On This Page</h3>
    
    @if($headings->count() > 0)
        <nav class="space-y-1">
            @foreach($headings as $heading)
                <a 
                    href="#{{ $heading['id'] }}"
                    class="block text-sm py-1.5 transition-colors border-l-2 pl-3 
                        {{ $heading['level'] === 2 ? '' : 'ml-' . (($heading['level'] - 2) * 3) }}
                        hover:text-white hover:border-brand-500"
                    :class="activeId === '{{ $heading['id'] }}' ? 'text-brand-400 border-brand-500' : 'text-gray-400 border-transparent'"
                    @click="activeId = '{{ $heading['id'] }}'"
                >
                    {{ $heading['text'] }}
                </a>
            @endforeach
        </nav>
    @else
        <p class="text-gray-500 text-sm">No sections found</p>
    @endif

    {{-- Reading time estimate --}}
    @php
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = max(1, ceil($wordCount / 200));
    @endphp
    <div class="mt-6 pt-4 border-t border-white/10">
        <div class="flex items-center gap-2 text-gray-500 text-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $readingTime }} min read</span>
        </div>
        <div class="flex items-center gap-2 text-gray-500 text-xs mt-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>{{ number_format($wordCount) }} words</span>
        </div>
    </div>
</div>

{{-- Add anchor IDs to headings via JS --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const content = document.querySelector('.article-content');
        if (!content) return;
        
        const headings = content.querySelectorAll('h2, h3, h4');
        headings.forEach((heading, index) => {
            heading.id = 'heading-' + (index + 1);
        });

        // Active heading tracking
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    document.querySelectorAll('[x-data] a').forEach(a => {
                        if (a.getAttribute('href') === '#' + entry.target.id) {
                            Alpine.store('activeId', entry.target.id);
                        }
                    });
                }
            });
        }, { rootMargin: '-20% 0px -80% 0px' });

        headings.forEach(h => observer.observe(h));
    });
</script>
@endpush
