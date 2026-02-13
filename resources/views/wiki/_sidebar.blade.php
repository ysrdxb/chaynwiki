@php
    $categories = [
        'artist' => ['label' => 'Artists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        'song' => ['label' => 'Songs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
        'genre' => ['label' => 'Genres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
        'playlist' => ['label' => 'Playlists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
        'label' => ['label' => 'Labels', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
        'term' => ['label' => 'Terminology', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
    ];
    $currentCategory = request('category') ?? ($article->category ?? null);
    $currentRoute = Route::currentRouteName();
    
    // Check if activeCrate exists in scope (mostly for index page)
    // If not, try to get it from request or view data if available globally
    // But since it's passed to view, we can rely on $activeCrate if set
    $activeCrateSlug = isset($activeCrate) && $activeCrate ? $activeCrate->slug : request('crate');
@endphp

<aside class="hidden lg:block w-72 sticky top-32 shrink-0 space-y-2 pr-8 border-r border-white/5">
    <div class="mb-10 px-4">
        <span class="text-white/20 text-[10px] font-black tracking-[0.4em] uppercase">Wiki Explorer</span>
    </div>
    
    <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black tracking-widest text-white/50 hover:text-white hover:bg-white/5 transition-all">
        <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-white/5 flex items-center justify-center group-hover:bg-blue-500 group-hover:scale-110 transition-all shadow-lg shadow-blue-500/10">
            <svg class="w-4 h-4 text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </div>
        Home
    </a>

    <a href="{{ route('wiki.index', array_filter(['crate' => $activeCrateSlug])) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black tracking-widest transition-all {{ $currentRoute === 'wiki.index' && !$currentCategory ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
        <div class="w-8 h-8 rounded-lg {{ $currentRoute === 'wiki.index' && !$currentCategory ? 'bg-blue-500' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
            <svg class="w-4 h-4 {{ $currentRoute === 'wiki.index' && !$currentCategory ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        </div>
        Library
    </a>

    <div class="h-px bg-white/5 mx-4 my-6"></div>
    
    @foreach($categories as $key => $cat)
        <a href="{{ route('wiki.index', array_filter(['category' => $key, 'crate' => $activeCrateSlug])) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black tracking-widest transition-all {{ $currentCategory === $key ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
            <div class="w-8 h-8 rounded-lg {{ $currentCategory === $key ? 'bg-blue-500' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                <svg class="w-4 h-4 {{ $currentCategory === $key ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
            </div>
            {{ $cat['label'] }}
        </a>
    @endforeach
</aside>
