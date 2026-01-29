@props(['type' => 'card', 'count' => 1])

@for ($i = 0; $i < $count; $i++)
    @switch($type)
        @case('card')
            <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6 animate-pulse">
                <div class="skeleton skeleton-card mb-4"></div>
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-text w-full"></div>
                <div class="skeleton skeleton-text w-3/4"></div>
            </div>
            @break

        @case('article')
            <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6 animate-pulse">
                <div class="flex items-center gap-4 mb-4">
                    <div class="skeleton w-12 h-12 rounded-full"></div>
                    <div class="flex-1">
                        <div class="skeleton skeleton-text w-32"></div>
                        <div class="skeleton skeleton-text w-20"></div>
                    </div>
                </div>
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-text w-full"></div>
                <div class="skeleton skeleton-text w-full"></div>
                <div class="skeleton skeleton-text w-2/3"></div>
            </div>
            @break

        @case('list')
            <div class="bg-[#0A0A14] border border-white/10 rounded-xl p-4 animate-pulse flex items-center gap-4">
                <div class="skeleton w-10 h-10 rounded-lg"></div>
                <div class="flex-1">
                    <div class="skeleton skeleton-text w-40"></div>
                    <div class="skeleton skeleton-text w-24"></div>
                </div>
            </div>
            @break

        @case('text')
            <div class="animate-pulse space-y-3">
                <div class="skeleton skeleton-text w-full"></div>
                <div class="skeleton skeleton-text w-full"></div>
                <div class="skeleton skeleton-text w-3/4"></div>
            </div>
            @break

        @case('hero')
            <div class="animate-pulse">
                <div class="skeleton h-16 w-3/4 mb-4"></div>
                <div class="skeleton h-8 w-1/2 mb-8"></div>
                <div class="skeleton h-12 w-96 rounded-full"></div>
            </div>
            @break
    @endswitch
@endfor
