@php
    $placeholder = 'https://images.unsplash.com/photo-1511367461989-f85a21fda167?auto=format&fit=crop&q=80&w=200';
    $avatar = $user->avatar ?: $placeholder;
@endphp

<div class="relative min-h-screen bg-[#0d1117]">
    <!-- Hero/Profile Header -->
    <section class="bg-[#0d1117] border-b border-white/5 pt-32 pb-16">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex flex-col md:flex-row items-start gap-8">
                <!-- Avatar with Badge -->
                <div class="relative shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-white/5 shadow-2xl">
                        <img src="{{ $avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    <!-- Verified Badge -->
                    <div class="absolute bottom-0 right-0 w-10 h-10 rounded-full bg-blue-400 border-4 border-[#0d1117] flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-2">{{ $user->name }}</h1>
                    <p class="text-white/40 text-sm font-bold mb-2">{{ '@' . $user->username }}</p>
                    <p class="text-white/30 text-xs font-medium mb-6">Contributor Since: {{ $user->created_at->format('F Y') }}</p>
                    <p class="text-white text-lg font-black mb-6">{{ number_format($points) }} Points</p>

                    @if($user->bio)
                        <p class="text-white/60 text-sm leading-relaxed max-w-3xl mb-8">{{ $user->bio }}</p>
                    @else
                        <p class="text-white/60 text-sm leading-relaxed max-w-3xl mb-8">
                            A passionate music enthusiast contributing high-quality information about artists, genres, and trending tracks. Helping the community discover accurate, verified music knowledge.
                        </p>
                    @endif

                    <!-- Stats Pills -->
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="action-pill bg-blue-400/20 border-blue-400/40">
                            <div class="pill-icon bg-blue-400"></div>
                            Topics Added: <strong>{{ $topicsAdded }}</strong>
                        </div>
                        <div class="action-pill bg-blue-400/20 border-blue-400/40">
                            <div class="pill-icon bg-blue-400"></div>
                            Edits Made: <strong>{{ $editsMade }}</strong>
                        </div>
                        <div class="action-pill bg-blue-400/20 border-blue-400/40">
                            <div class="pill-icon bg-blue-400"></div>
                            Approved Contributions: <strong>{{ $approvedContributions }}</strong>
                        </div>
                        <div class="action-pill bg-blue-400/20 border-blue-400/40">
                            <div class="pill-icon bg-blue-400"></div>
                            Pending Reviews: <strong>{{ $pendingReviews }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Contribution History Button -->
                <div class="shrink-0">
                    <button class="btn-figma-secondary flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Contribution History
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Badges Section -->
    @if(count($badges) > 0)
    <section class="bg-[#0d1117] section-unified py-16 border-t border-white/5">
        <div class="max-w-[1400px] mx-auto px-8">
            <h2 class="section-title mb-8">Achievement Badges</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($badges as $badge)
                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-8 hover:border-blue-400/20 hover:bg-[#161b22]/60 transition-all">
                    <div class="mb-4">
                        <div class="w-14 h-14 rounded-full bg-blue-400/10 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-white text-base font-black uppercase tracking-tighter mb-2">{{ $badge['title'] }}</h3>
                    <p class="text-white/50 text-xs font-medium">{{ $badge['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Topics Added Section -->
    <section class="bg-[#0d1117] section-unified py-16 border-t border-white/5">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="section-title">Topics Added by {{ $user->name }}</h2>
                
                <!-- Navigation Arrows -->
                <div class="flex items-center gap-2">
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:border-white/20 hover:bg-white/5 transition-all">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:border-white/20 hover:bg-white/5 transition-all">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Article Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($articles as $article)
                    @include('wiki._article-card', ['article' => $article])
                @empty
                    <div class="col-span-full text-center py-20 bg-[#161b22]/40 border border-white/5 rounded-[20px]">
                        <div class="text-4xl mb-4">📂</div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-2">No Topics Yet</h3>
                        <p class="text-white/40 text-sm">This contributor hasn't added any topics yet.</p>
                    </div>
                @endforelse
            </div>

            @if($articles->count() >= 12)
            <div class="text-center mt-12">
                <a href="{{ route('wiki.index', ['user' => $user->username]) }}" class="btn-figma-primary inline-flex items-center gap-2">
                    View All Topics
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endif
        </div>
    </section>
</div>
