@php
    $placeholder = 'https://images.unsplash.com/photo-1511367461989-f85a21fda167?auto=format&fit=crop&q=80&w=200';
    $avatar = $user->avatar ?: $placeholder;
@endphp

<div class="relative min-h-screen bg-[#0d1117]">
    <!-- Hero/Profile Header -->
    <section class="bg-[#0d1117] relative pt-40 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-blue-500/[0.02] -z-10"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-[150px] -z-10"></div>
        
        <div class="max-w-[1400px] mx-auto px-8 relative">
            <div class="flex flex-col md:flex-row items-start gap-8">
                <!-- Avatar with Badge -->
                <div class="relative shrink-0 group">
                    <div class="w-40 h-40 md:w-56 md:h-56 rounded-[3rem] overflow-hidden border-4 border-white/5 shadow-3xl bg-[#161b22] relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                        @else
                            <div class="w-full h-full bg-blue-500/10 flex items-center justify-center">
                                <span class="text-7xl font-black text-blue-500/30 group-hover:text-blue-500 group-hover:scale-110 transition-all duration-700" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ ucfirst(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <!-- Verified Badge -->
                    <div class="absolute -bottom-4 -right-4 w-14 h-14 rounded-2xl bg-blue-500 border-[6px] border-[#0d1117] flex items-center justify-center shadow-3xl group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-1 mt-6 md:mt-0">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="px-3 py-1 bg-white/5 border border-white/5 rounded-full text-[10px] font-black text-white/40 tracking-widest">Verified contributor</span>
                        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full text-[10px] font-black text-blue-500 tracking-widest">Sonic Bridge v1.1</span>
                        <span class="text-white/20 text-xs font-black tracking-[0.2em] ml-2">Established {{ $user->created_at->format('Y') }}</span>
                    </div>
                    <h1 class="text-[64px] md:text-[84px] font-black text-white tracking-tightest mb-4 leading-[0.8]" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $user->name }}</h1>
                    
                    <div class="flex items-center gap-6 mb-8">
                        <p class="text-blue-500 text-[14px] font-black tracking-widest">{{ '@' . $user->username }}</p>
                        <div class="w-1.5 h-1.5 rounded-full bg-white/10"></div>
                        <p class="text-white text-[16px] font-black tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;"><span class="text-white/20 mr-2">Credits:</span> {{ number_format($points) }}</p>
                    </div>

                    @if($user->bio)
                        <p class="text-white/40 text-[13px] font-black tracking-widest leading-[1.6] max-w-2xl mb-10">{{ $user->bio }}</p>
                    @else
                        <p class="text-white/20 text-[13px] font-black tracking-widest leading-[1.6] max-w-2xl mb-10">
                            A high-tier contributor ensuring the precision of global music records. Actively curating the music archive.
                        </p>
                    @endif

                    <!-- Stats pills refined -->
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="card-premium h-auto !py-3 !px-6 border-blue-500/10 hover:border-blue-500/30">
                            <span class="text-[9px] font-black text-white/20 tracking-widest block mb-1">Topics</span>
                            <span class="text-[14px] font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $topicsAdded }} <span class="text-white/10 text-[10px] ml-1">added</span></span>
                        </div>
                        <div class="card-premium h-auto !py-3 !px-6 border-blue-500/10 hover:border-blue-500/30">
                            <span class="text-[9px] font-black text-white/20 tracking-widest block mb-1">Revisions</span>
                            <span class="text-[14px] font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $editsMade }} <span class="text-white/10 text-[10px] ml-1">edits</span></span>
                        </div>
                        <div class="card-premium h-auto !py-3 !px-6 border-blue-500/10 hover:border-blue-500/30">
                            <span class="text-[9px] font-black text-white/20 tracking-widest block mb-1">Approved</span>
                            <span class="text-[14px] font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $approvedContributions }} <span class="text-white/10 text-[10px] ml-1">verified</span></span>
                        </div>
                        <div class="card-premium h-auto !py-3 !px-6 border-blue-500/10 hover:border-blue-500/30">
                            <span class="text-[9px] font-black text-white/20 tracking-widest block mb-1">In Queue</span>
                            <span class="text-[14px] font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $pendingReviews }} <span class="text-white/10 text-[10px] ml-1">pending</span></span>
                        </div>
                    </div>

                    <!-- Spotify Now Playing -->
                    <div class="max-w-sm mt-8">
                        <livewire:spotify-now-playing :user="$user" />
                        
                        @guest
                            <div class="mt-4 p-4 rounded-2xl bg-white/5 border border-white/5">
                                <p class="text-[10px] font-black text-white/40 uppercase tracking-widest text-center">
                                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400">Log in</a> to connect your Spotify
                                </p>
                            </div>
                        @endguest

                        @auth
                            @if(auth()->id() != $user->id && empty($user->spotify_token))
                                <div class="mt-4 p-4 rounded-2xl bg-white/5 border border-white/5">
                                    <p class="text-[10px] font-black text-white/20 uppercase tracking-widest text-center">
                                        User has not linked Spotify
                                    </p>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="shrink-0 pt-8 md:pt-0">
                    <button wire:click="toggleHistory" class="group flex items-center gap-4 px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-[2rem] font-black transition-all duration-300 shadow-3xl shadow-blue-500/20">
                        <span class="tracking-tight">{{ $showHistory ? 'Close history' : 'Contribution logs' }}</span>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-white group-hover:text-blue-500 transition-all">
                            @if($showHistory)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    @if($showHistory)
        {{-- History View --}}
        <section class="bg-[#0d1117] py-20 border-t border-white/5 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-500/[0.01] pointer-events-none"></div>
            <div class="max-w-[1400px] mx-auto px-8 relative">
                <div class="flex items-center justify-between mb-16">
                    <h2 class="text-3xl font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">Contribution logs <span class="text-white/10 ml-4 font-black">/ Activity history</span></h2>
                    <span class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-xl text-[10px] font-black text-blue-400 tracking-widest">Active Connection</span>
                </div>
                
                <div class="space-y-6">
                    @forelse($user->revisions()->with('article')->latest()->take(50)->get() as $revision)
                        <div class="group relative">
                            <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-1 h-0 group-hover:h-full bg-blue-500 transition-all duration-500 rounded-full"></div>
                            <div class="card-premium !bg-[#161b22]/40 backdrop-blur-sm !p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:translate-x-2 transition-all duration-500 border border-white/5 hover:border-blue-500/20">
                                <div class="flex items-center gap-8">
                                    <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-blue-500/10 transition-colors">
                                        <svg class="w-7 h-7 text-white/20 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-4.514A9.01 9.01 0 0012 21a9.003 9.003 0 008.384-5.91M8.211 14.243a8 8 0 1111.314 0M15 11l3 3m0 0l-3 3m3-3H9"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-black text-white tracking-tightest mb-2">{{ $revision->article->title ?? 'Deleted topic' }}</h4>
                                        <div class="flex items-center gap-4">
                                            <p class="text-white/20 text-[10px] font-black tracking-widest">{{ $revision->created_at->diffForHumans() }}</p>
                                            <div class="w-1 h-1 rounded-full bg-white/10"></div>
                                            <p class="text-blue-500/40 text-[10px] font-black tracking-widest">Edit type: {{ $revision->type ?? 'Patch' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <span class="px-5 py-2 rounded-xl text-[10px] font-black tracking-widest shadow-2xl
                                        {{ $revision->status === 'approved' ? 'bg-green-500/10 text-green-400 border border-green-500/10' : 
                                           ($revision->status === 'rejected' ? 'bg-red-500/10 text-red-400 border border-red-500/10' : 
                                           'bg-yellow-500/10 text-yellow-500 border border-yellow-500/10 shadow-yellow-500/5') }}">
                                        {{ $revision->status }}
                                    </span>
                                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-32 rounded-[3rem] border border-dashed border-white/5 bg-white/[0.01]">
                            <p class="text-white/10 text-[12px] font-black tracking-[0.5em]">No synchronization history detected</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @else
        <!-- Badges Section -->
        @if(count($badges) > 0)
        <section class="bg-[#0d1117] py-20 border-t border-white/5 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-500/[0.02] -z-10"></div>
            <div class="max-w-[1400px] mx-auto px-8 relative">
                <div class="flex items-center justify-between mb-16">
                    <h2 class="text-3xl font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">Achievements <span class="text-white/10 ml-4 font-black">/ Contributor status</span></h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($badges as $badge)
                    <div class="card-premium !bg-[#161b22]/40 backdrop-blur-sm !p-10 hover:translate-y-[-8px] transition-all duration-500 group border-white/5 hover:border-blue-500/30">
                        <div class="mb-10 relative">
                            <div class="absolute inset-0 bg-blue-500/20 rounded-full blur-[30px] opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            <div class="w-20 h-20 rounded-[2rem] bg-blue-500/10 flex items-center justify-center relative z-10 group-hover:bg-blue-500 transition-colors duration-500 shadow-3xl">
                                <svg class="w-10 h-10 text-blue-500 group-hover:text-white transition-colors duration-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-black text-white tracking-tightest mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $badge['title'] }}</h3>
                        <p class="text-white/20 text-[11px] font-black tracking-widest leading-relaxed group-hover:text-white/40 transition-colors">{{ $badge['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Topics Added Section -->
        <section class="bg-[#0d1117] py-24 border-t border-white/5" 
                 x-data="{ 
                    scrollLeft() { this.$refs.slider.scrollBy({ left: -400, behavior: 'smooth' }) },
                    scrollRight() { this.$refs.slider.scrollBy({ left: 400, behavior: 'smooth' }) }
                 }">
            <div class="max-w-[1400px] mx-auto px-8">
                <div class="flex items-center justify-between mb-16 px-4">
                    <div class="flex items-center gap-6">
                        <div class="w-10 h-1 bg-blue-500 rounded-full"></div>
                        <h2 class="text-3xl font-black text-white tracking-tightest">Archive contributions</h2>
                    </div>
                    
                    <!-- Navigation Arrows Refined -->
                    <div class="flex items-center gap-4">
                        <button @click="scrollLeft()" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-white/10 hover:border-white/10 transition-all text-white/20 hover:text-white shadow-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="scrollRight()" class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-white/5 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all text-blue-500 shadow-2xl shadow-blue-500/5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Article Carousel -->
                <div x-ref="slider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-8 scroll-smooth">
                    @forelse($articles as $article)
                        <div class="snap-start shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                            @include('wiki._article-card', ['article' => $article])
                        </div>
                    @empty
                        <div class="w-full py-32 bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[3rem] flex flex-col items-center justify-center text-center shadow-3xl">
                            <div class="w-24 h-24 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-10 shadow-3xl">
                                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            </div>
                            <h3 class="text-3xl font-black text-white tracking-tightest mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">Archive empty</h3>
                            <p class="text-white/20 text-[11px] font-black tracking-widest max-w-sm mx-auto">This contributor has not added any data to the archive yet.</p>
                        </div>
                    @endforelse
                </div>

                @if($articles->count() >= 12)
                <div class="text-center mt-20">
                    <a href="{{ route('wiki.index', ['user' => $user->username]) }}" class="btn-figma-secondary !px-12 !py-5 shadow-3xl">
                        <span>Expand Data View</span>
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center shadow-inner">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </div>
                    </a>
                </div>
                @endif
            </div>

            <style>
                .no-scrollbar::-webkit-scrollbar { display: none; }
                .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            </style>
        </section>
    @endif
</div>
