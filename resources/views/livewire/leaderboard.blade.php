<div class="min-h-screen bg-primary pt-32 pb-24" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    <div class="max-w-[1200px] mx-auto px-8">
        
        <!-- Header -->
        <div class="relative pb-16 border-b border-white/5 mb-16 px-1">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div>
                    <nav class="flex items-center gap-2 text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-6">
                        <a href="{{ route('home') }}" class="hover:text-[#38bdf8] transition-colors">Home</a>
                        <span>/</span>
                        <span class="text-[#38bdf8]">Global Impact Index</span>
                    </nav>

                    <h1 class="text-4xl lg:text-6xl font-black text-white italic uppercase tracking-tighter mb-3 leading-none">
                        Top <span class="text-[#38bdf8]">Contributors</span> & Entries
                    </h1>

                    <p class="text-sm text-white/50 max-w-2xl">
                        Discover the most impactful entries and contributors based on reach, growth, and trusted revisions.
                    </p>
                </div>
                
                <div class="flex items-center gap-3 p-3.5 bg-secondary border border-white/5 rounded-xl shadow-xl">
                    <div class="w-9 h-9 rounded-lg bg-[#38bdf8]/5 border border-[#38bdf8]/10 flex items-center justify-center text-[#38bdf8]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <span class="text-white font-black block leading-none mb-1 text-[10px] uppercase tracking-wider">Index Protocol</span>
                        <span class="text-[10px] text-white/50 font-semibold">Live sync active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Dashboard Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-12">
            <!-- Sidebar Filters -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-xs font-black text-white/50 uppercase tracking-[0.3em] mb-4 px-1">Filter by type</h3>
                    <div class="space-y-2">
                        @foreach(['All', 'Recordings', 'Artist Profiles', 'Classifications'] as $cat)
                        <button 
                            wire:click="setFilter('{{ $cat }}')"
                            class="w-full text-left px-5 py-3.5 rounded-xl text-[11px] font-semibold tracking-wide transition-all {{ $activeFilter === $cat ? 'bg-[#38bdf8] text-[#0a0e14] shadow-xl shadow-[#38bdf8]/10' : 'bg-white/5 text-white/60 border border-white/5 hover:border-white/10 hover:text-white' }}">
                            {{ $cat }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-black text-white/50 uppercase tracking-[0.3em] mb-4 px-1">Sort by</h3>
                    <div class="space-y-2">
                        @foreach(['Impact Score', 'Metadata Growth', 'Total Connections'] as $sort)
                        <button 
                            wire:click="setSort('{{ $sort }}')"
                            class="w-full text-left px-5 py-3.5 rounded-xl text-[11px] font-semibold tracking-wide transition-all {{ $activeSort === $sort ? 'bg-[#38bdf8] text-[#0a0e14] shadow-xl shadow-[#38bdf8]/10' : 'border border-white/5 text-white/60 hover:border-white/10 hover:text-white' }}">
                            {{ $sort }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Rankings Data Display -->
            <div class="lg:col-span-3">
                <div class="bg-secondary border border-white/5 rounded-2xl overflow-hidden shadow-2xl relative">
                    <div wire:loading class="absolute inset-0 bg-black/60 backdrop-blur-md z-20 flex items-center justify-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-12 h-12 border-4 border-[#38bdf8]/10 border-t-[#38bdf8] rounded-full animate-spin"></div>
                            <span class="text-[10px] font-black text-[#38bdf8] uppercase tracking-widest">Re-Indexing Records...</span>
                        </div>
                    </div>

                    <!-- Table Structure -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-white/[0.02]">
                                    <th class="px-6 py-4 text-[10px] font-semibold text-white/60 uppercase tracking-widest text-left">Entry</th>
                                    <th class="px-6 py-4 text-[10px] font-semibold text-white/60 uppercase tracking-widest text-left">Category</th>
                                    <th class="px-6 py-4 text-[10px] font-semibold text-white/60 uppercase tracking-widest text-left">Impact</th>
                                    <th class="px-6 py-4 text-[10px] font-semibold text-white/60 uppercase tracking-widest text-right">Open</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                {{-- Dynamic Data Loaded from Component --}}

                                <template x-if="!loaded">
                                    @for($i = 0; $i < 4; $i++)
                                    <tr>
                                        <td colspan="4" class="px-8 py-6"><div class="skeleton-v2 h-16 w-full rounded-2xl"></div></td>
                                    </tr>
                                    @endfor
                                </template>

                                @foreach($rankings as $index => $item)
                                <tr class="group hover:bg-white/[0.03] transition-all border-b border-white/[0.03] last:border-0">
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-6">
                                            <span class="text-2xl font-black text-white/20 italic w-8">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="text-white font-bold uppercase tracking-tight group-hover:text-[#38bdf8] transition-colors">{{ $item['title'] }}</div>
                                                <div class="text-[10px] font-semibold text-white/40 uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                                    <span class="w-1 h-1 rounded-full bg-[#38bdf8]/20"></span>
                                                    Authorized by {{ $item['user'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="px-3 py-1 bg-[#38bdf8]/10 border border-[#38bdf8]/20 rounded-lg text-[9px] font-semibold text-[#7dd3fc] uppercase tracking-widest">
                                            {{ $item['cat'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-8">
                                            <div class="flex flex-col">
                                                <span class="text-white font-bold text-sm">{{ $item['reach'] }}</span>
                                                <span class="text-[10px] font-semibold text-white/40 uppercase tracking-widest mt-1">Global reach</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[#38bdf8] font-bold text-sm">{{ $item['growth'] }}</span>
                                                <span class="text-[10px] font-semibold text-white/40 uppercase tracking-widest mt-1">Growth</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-right">
                                        <a href="{{ route('wiki.show', $item['slug']) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white/5 border border-white/10 rounded-xl text-[10px] font-semibold text-white/70 uppercase tracking-[0.2em] hover:bg-white/10 hover:text-white transition-all active:scale-95">
                                            View Entry
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Contributor Nodes Section -->
                @if(count($leaderboard) > 0)
                <div class="mt-12">
                    <div class="flex items-center gap-4 mb-8">
                        <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">Top Contributors</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($leaderboard as $index => $user)
                        <div class="card-v2 p-5 bg-secondary border-white/5 group hover:border-[#38bdf8]/20">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-lg font-black text-white/30 italic group-hover:text-[#38bdf8] transition-colors">
                                            {{ strtoupper(substr($user['name'],0,1)) }}
                                        </div>
                                        @if($index < 3)
                                        <div class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-[#38bdf8] flex items-center justify-center text-[9px] text-[#0a0e14] font-black shadow-lg shadow-[#38bdf8]/10">
                                            {{ $index + 1 }}
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-white font-semibold uppercase tracking-tight text-base leading-tight">{{ $user['name'] }}</div>
                                        <div class="text-[10px] font-semibold text-white/40 uppercase tracking-widest mt-1">Level {{ $user['level'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-white font-bold text-base">{{ $user['reputation_score'] }}</div>
                                    <div class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Impact points</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Join the Archive -->
        <div class="mt-20 pt-12 border-t border-white/5 text-center">
            <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter mb-4">Contribute to the Archive</h2>
            <p class="text-white/50 text-sm max-w-md mx-auto mb-8">Add new records, refine articles, and earn impact for verified contributions.</p>
            <a href="{{ route('wiki.create') }}" class="btn-primary-v2 pr-10 pl-8 py-3.5 shadow-xl shadow-[#38bdf8]/10">
                Create a new entry
            </a>
        </div>
    </div>
</div>
