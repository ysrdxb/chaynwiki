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
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-white/10 shadow-2xl bg-[#161b22]">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-blue-500/20 flex items-center justify-center">
                                <span class="text-5xl md:text-6xl font-black text-blue-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <!-- Verified Badge -->
                    <div class="absolute bottom-0 right-0 w-10 h-10 rounded-full bg-blue-500 border-4 border-[#0d1117] flex items-center justify-center shadow-lg shadow-blue-500/20">
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
                        <div class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-xs font-bold text-blue-400 flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            Topics Added: <strong class="text-white">{{ $topicsAdded }}</strong>
                        </div>
                        <div class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-xs font-bold text-blue-400 flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            Edits Made: <strong class="text-white">{{ $editsMade }}</strong>
                        </div>
                        <div class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-xs font-bold text-blue-400 flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            Approved Contributions: <strong class="text-white">{{ $approvedContributions }}</strong>
                        </div>
                        <div class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-xs font-bold text-blue-400 flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            Pending Reviews: <strong class="text-white">{{ $pendingReviews }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Contribution History Button -->
                <div class="shrink-0">
                    <button class="px-6 py-3 bg-[#161b22] hover:bg-[#1c2128] border border-white/5 hover:border-white/10 rounded-xl text-xs font-bold text-white uppercase tracking-widest transition-all flex items-center gap-2 group">
                        <svg class="w-4 h-4 text-white/40 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
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
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter mb-8">Achievement Badges</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($badges as $badge)
                <div class="bg-[#161b22] border border-white/5 rounded-[20px] p-8 hover:border-blue-500/30 hover:shadow-lg hover:shadow-blue-500/5 transition-all group">
                    <div class="mb-4">
                        <div class="w-14 h-14 rounded-full bg-blue-500/10 flex items-center justify-center mb-4 group-hover:bg-blue-500/20 transition-colors">
                            <svg class="w-7 h-7 text-blue-500 group-hover:text-blue-400 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-white text-base font-black uppercase tracking-tighter mb-2">{{ $badge['title'] }}</h3>
                    <p class="text-white/50 text-xs font-medium leading-relaxed">{{ $badge['description'] }}</p>
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
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Topics Added by {{ $user->name }}</h2>
                
                <!-- Navigation Arrows -->
                <div class="flex items-center gap-2">
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:border-white/20 hover:bg-white/5 transition-all text-white/40 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:border-white/20 hover:bg-white/5 transition-all text-white/40 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Article Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($articles as $article)
                    @include('wiki._article-card', ['article' => $article])
                @empty
                    <div class="col-span-full py-20 bg-[#161b22] border border-white/5 rounded-[20px] flex flex-col items-center justify-center text-center">
                        <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-2">No Topics Yet</h3>
                        <p class="text-white/40 text-sm max-w-sm mx-auto">This contributor hasn't added any topics to the ChaynWiki yet.</p>
                    </div>
                @endforelse
            </div>

            @if($articles->count() >= 12)
            <div class="text-center mt-12">
                <a href="{{ route('wiki.index', ['user' => $user->username]) }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-widest text-xs rounded-full inline-flex items-center gap-2 transition-all hover:scale-105 shadow-lg shadow-blue-600/20">
                    View All Topics
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endif
        </div>
    </section>
</div>
