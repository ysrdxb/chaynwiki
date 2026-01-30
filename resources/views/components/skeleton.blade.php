{{--
    Skeleton Loading Components V2
    Premium shimmer effect with glassmorphism
--}}

@props(['type' => 'card', 'count' => 1])

@pushOnce('styles')
<style>
    .skeleton-v2 {
        background: linear-gradient(
            90deg, 
            rgba(255,255,255,0.03) 0%, 
            rgba(255,255,255,0.08) 50%, 
            rgba(255,255,255,0.03) 100%
        );
        background-size: 200% 100%;
        animation: skeleton-shimmer 1.5s ease-in-out infinite;
        border-radius: 8px;
    }
    @keyframes skeleton-shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .skeleton-card-v2 {
        background: linear-gradient(135deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
    }
</style>
@endPushOnce

@for ($i = 0; $i < $count; $i++)
    @switch($type)
        @case('topic-card')
            {{-- Topic Card Skeleton --}}
            <div class="skeleton-card-v2 overflow-hidden">
                <div class="aspect-[16/9] skeleton-v2"></div>
                <div class="p-5">
                    <div class="skeleton-v2 h-5 w-3/4 mb-2"></div>
                    <div class="skeleton-v2 h-4 w-1/2"></div>
                </div>
            </div>
            @break

        @case('stat-card')
            {{-- Stat Card Skeleton --}}
            <div class="skeleton-card-v2 p-5 text-center">
                <div class="skeleton-v2 h-4 w-20 mx-auto mb-3"></div>
                <div class="skeleton-v2 h-8 w-16 mx-auto"></div>
            </div>
            @break

        @case('category-card')
            {{-- Category Card Skeleton --}}
            <div class="skeleton-card-v2 flex items-center justify-between p-4">
                <div>
                    <div class="skeleton-v2 h-4 w-24 mb-2"></div>
                    <div class="skeleton-v2 h-3 w-16"></div>
                </div>
                <div class="skeleton-v2 w-4 h-4 rounded"></div>
            </div>
            @break

        @case('genre-card')
            {{-- Genre Card Skeleton --}}
            <div class="skeleton-card-v2 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="skeleton-v2 h-5 w-28"></div>
                    <div class="skeleton-v2 w-5 h-5 rounded"></div>
                </div>
                <div class="skeleton-v2 h-4 w-full mb-3"></div>
                <div class="skeleton-v2 h-3 w-20"></div>
            </div>
            @break

        @case('table-row')
            {{-- Table Row Skeleton --}}
            <tr class="border-b border-white/5">
                <td class="px-5 py-4"><div class="skeleton-v2 h-4 w-6"></div></td>
                <td class="px-5 py-4"><div class="skeleton-v2 h-4 w-32"></div></td>
                <td class="px-5 py-4"><div class="skeleton-v2 h-6 w-16 rounded-full"></div></td>
                <td class="px-5 py-4"><div class="skeleton-v2 h-4 w-12"></div></td>
                <td class="px-5 py-4"><div class="skeleton-v2 h-4 w-24"></div></td>
            </tr>
            @break

        @case('insight-card')
            {{-- Insight Card Skeleton --}}
            <div class="skeleton-card-v2 p-6">
                <div class="skeleton-v2 h-3 w-28 mb-4"></div>
                <div class="skeleton-v2 h-6 w-36 mb-2"></div>
                <div class="skeleton-v2 h-3 w-24"></div>
            </div>
            @break

        @case('progress-ring')
            {{-- Progress Ring Skeleton --}}
            <div class="w-[120px] h-[120px] rounded-full skeleton-v2"></div>
            @break

        @case('hero')
            {{-- Hero Skeleton --}}
            <div class="animate-pulse">
                <div class="skeleton-v2 h-6 w-40 rounded-full mb-6"></div>
                <div class="skeleton-v2 h-14 w-full max-w-lg mb-3"></div>
                <div class="skeleton-v2 h-14 w-full max-w-md mb-6"></div>
                <div class="skeleton-v2 h-5 w-64 mb-10"></div>
                <div class="skeleton-v2 h-14 w-full max-w-xl rounded-full mb-8"></div>
                <div class="flex gap-6">
                    <div class="skeleton-v2 h-4 w-24"></div>
                    <div class="skeleton-v2 h-4 w-28"></div>
                    <div class="skeleton-v2 h-4 w-24"></div>
                </div>
            </div>
            @break

        @default
            {{-- Default Card Skeleton --}}
            <div class="skeleton-card-v2 p-6">
                <div class="skeleton-v2 h-40 w-full mb-4"></div>
                <div class="skeleton-v2 h-5 w-3/4 mb-3"></div>
                <div class="skeleton-v2 h-4 w-full mb-2"></div>
                <div class="skeleton-v2 h-4 w-2/3"></div>
            </div>
    @endswitch
@endfor
