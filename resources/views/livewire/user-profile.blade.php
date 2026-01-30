<div class="relative min-h-screen bg-primary pt-32 pb-24" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-blue-900/10 via-[#050511] to-[#050511]"></div>
    </div>

    <div class="relative z-10 max-w-[1200px] mx-auto px-8 relative">
        <!-- Profile Header -->
        <div class="bg-secondary border border-white/5 rounded-2xl p-8 md:p-14 mb-16 shadow-2xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-[500px] h-[500px] bg-blue-500/5 blur-[120px] rounded-full -mr-60 -mt-60 transition-all duration-1000 group-hover:bg-blue-500/10"></div>
            
            <div class="flex flex-col md:flex-row items-center md:items-start gap-16 relative z-10">
                <!-- Avatar Node -->
                <div class="shrink-0 relative">
                    <div class="w-44 h-44 md:w-64 md:h-64 rounded-2xl overflow-hidden border border-white/5 shadow-2xl bg-primary flex items-center justify-center group/avatar relative">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover group-hover/avatar:scale-110 transition-transform duration-1000">
                        @else
                            <span class="text-7xl font-black text-white/5 italic select-none">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover/avatar:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-blue-600 px-5 py-2 rounded-xl border border-[#050511] shadow-2xl text-[10px] font-black uppercase tracking-[0.2em] text-white whitespace-nowrap shadow-blue-500/20">
                        NODE LEVEL {{ $user->level }}
                    </div>
                </div>

                <!-- Identity Info -->
                <div class="flex-1 text-center md:text-left py-2">
                    <div class="mb-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-500/5 border border-blue-500/10 text-[9px] font-black text-blue-500 uppercase tracking-[0.2em] mb-4">
                            Authorized Node Identity
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-white mb-3 uppercase italic tracking-tighter leading-none">
                            {{ $user->name }}
                        </h1>
                        <p class="text-white/20 font-black text-[12px] uppercase tracking-[0.4em] italic">{{ '@' . $user->username }}</p>
                    </div>

                    @if($user->bio)
                        <p class="text-white/40 text-lg leading-relaxed max-w-xl mb-10 italic">"{{ $user->bio }}"</p>
                    @else
                        <p class="text-white/10 text-[11px] font-black uppercase tracking-widest mb-10 italic leading-loose">Node metadata synchronization in progress...</p>
                    @endif

                    <div class="flex flex-wrap justify-center md:justify-start gap-10 text-[10px] font-black text-white/10 uppercase tracking-[0.2em] items-center">
                        @if($user->location)
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $user->location }}
                            </div>
                        @endif
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Activated {{ $user->created_at->format('M Y') }}
                        </div>
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('settings') }}" wire:navigate class="px-8 py-3 bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl text-[9px] font-black text-white/40 transition-all uppercase tracking-[0.2em] hover:text-white">
                                CONFIGURATION
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Identity Analytics -->
                <div class="grid grid-cols-2 gap-4 w-full md:w-80">
                    <div class="bg-primary/40 border border-white/5 rounded-2xl p-6 text-center group/stat hover:border-blue-500/20 transition-all shadow-xl">
                        <div class="text-3xl font-black text-white group-hover/stat:text-blue-500 transition-colors uppercase italic tracking-tighter">{{ $user->reputation_score }}</div>
                        <div class="text-[9px] text-white/10 uppercase tracking-[0.2em] font-black mt-2">Reputation</div>
                    </div>
                    <div class="bg-primary/40 border border-white/5 rounded-2xl p-6 text-center group/stat hover:border-blue-500/20 transition-all shadow-xl">
                        <div class="text-3xl font-black text-white group-hover/stat:text-blue-500 transition-colors uppercase italic tracking-tighter">{{ $revisionsCount }}</div>
                        <div class="text-[9px] text-white/10 uppercase tracking-[0.2em] font-black mt-2">Commits</div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Sidebar: Node Status -->
            <div class="space-y-8">
                <div class="bg-secondary border border-white/5 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-[9px] font-black text-white/20 uppercase tracking-[0.2em] mb-6 pb-3 border-b border-white/5 italic">Archive Badges</h3>
                    <div class="grid grid-cols-4 gap-3">
                        <div class="aspect-square rounded-xl bg-blue-500/5 border border-blue-500/10 flex items-center justify-center text-blue-500 shadow-lg shadow-blue-500/5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <div class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/5 italic font-black">?</div>
                        <div class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/5 italic font-black">?</div>
                        <div class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/5 italic font-black">?</div>
                    </div>
                </div>

                <div class="bg-secondary border border-white/5 rounded-2xl p-6">
                    <h3 class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] mb-8 pb-4 border-b border-white/5">Network Registry</h3>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center text-[10px] font-black">
                            <span class="text-white/20 uppercase tracking-widest">Trust Level</span>
                            <span class="text-blue-500 tracking-widest">TIER ALPHA</span>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-black">
                            <span class="text-white/20 uppercase tracking-widest">Registration</span>
                            <span class="text-green-500 tracking-widest">VERIFIED</span>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-black">
                            <span class="text-white/20 uppercase tracking-widest">Data Uptime</span>
                            <span class="text-white tracking-widest">99.9%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity: Recent Archives -->
            <div class="lg:col-span-2 space-y-12">
                <div class="flex items-center justify-between mb-8 px-1">
                    <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">Contribution Log</h2>
                    <span class="text-[9px] font-black text-white/10 uppercase tracking-[0.3em] italic">Archive Feed</span>
                </div>
                
                <div class="space-y-6">
                    @forelse($articles as $article)
                        <a href="{{ route('wiki.show', $article->slug) }}" wire:navigate class="group block bg-secondary border border-white/5 rounded-2xl p-8 hover:border-blue-500/20 transition-all duration-500 relative overflow-hidden shadow-2xl">
                            <div class="absolute inset-0 bg-blue-500/[0.01] group-hover:bg-blue-500/[0.02] transition-colors"></div>
                            
                            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-10">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-4">
                                        <span class="px-3 py-1 bg-blue-500/5 text-blue-500 text-[9px] font-black uppercase tracking-[0.2em] rounded-lg border border-blue-500/10 shadow-lg">{{ $article->category }}</span>
                                        <span class="text-[9px] font-black text-white/5 uppercase tracking-[0.3em] italic">{{ $article->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="text-2xl font-black text-white group-hover:text-blue-500 transition-colors mb-3 uppercase italic tracking-tighter leading-none">{{ $article->title }}</h4>
                                    <p class="text-white/20 text-[11px] leading-relaxed max-w-xl line-clamp-2 uppercase font-black tracking-widest italic leading-loose">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}</p>
                                </div>
                                <div class="shrink-0 group-hover:translate-x-3 transition-transform duration-500">
                                    <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/5 group-hover:bg-blue-600 group-hover:border-blue-600 group-hover:text-white group-hover:shadow-xl group-hover:shadow-blue-500/20 transition-all">
                                        <svg class="w-5 h-5 translate-x-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-20 bg-secondary/40 border border-dashed border-white/5 rounded-2xl shadow-xl">
                            <svg class="w-16 h-16 text-white/5 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-2 italic">NULL RECORDS</h3>
                            <p class="text-white/10 text-[10px] font-black uppercase tracking-[0.3em] italic">No initialized archive sequences detected.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
