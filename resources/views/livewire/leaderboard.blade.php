<div class="relative min-h-screen bg-[#0d1117] pt-32 pb-24 overflow-hidden" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    {{-- Background Blobs match homepage --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#3b82f6]/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[30%] h-[30%] bg-purple-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute top-[40%] right-[10%] w-[20%] h-[20%] bg-[#3b82f6]/5 blur-[100px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-8">
        
        <!-- Header Section -->
        <div class="relative mb-20">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-12">
                <div class="relative">
                    {{-- Sparkle Icon --}}
                    <div class="absolute -top-8 -right-12 text-white/20">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5L12 0z"/>
                        </svg>
                    </div>

                    <h1 class="text-[64px] md:text-[80px] font-black text-white uppercase leading-none tracking-tighter mb-6" style="font-family: 'Moderniz', 'Inter', sans-serif;">
                        RANKINGS
                    </h1>
                    <p class="text-[16px] font-bold text-white/40 uppercase tracking-widest">
                        Ranked by views, SEO score, freshness, and community engagement.
                    </p>
                </div>

                {{-- Filters Bar --}}
                <div class="flex flex-wrap items-center gap-8 mb-4">
                    <div class="flex items-center gap-4">
                        <span class="text-white/20 text-[11px] font-black uppercase tracking-widest">Filters</span>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-4 px-8 py-2.5 border border-white/10 rounded-full text-[13px] font-bold text-white hover:border-white/20 transition-all min-w-[160px] justify-between">
                                <span>{{ $activeFilter === 'All' ? 'Page Type' : $activeFilter }}</span>
                                <svg class="w-4 h-4 text-white/30" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute top-full right-0 mt-3 w-48 bg-[#161b22] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50 py-2" style="display: none;">
                                @foreach(['All', 'Song', 'Artist', 'Genre'] as $cat)
                                    <button wire:click="setFilter('{{ $cat }}')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $activeFilter === $cat ? 'text-blue-500' : 'text-white/60' }}">{{ $cat }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-white/20 text-[11px] font-black uppercase tracking-widest">Sort</span>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-4 px-8 py-2.5 border border-white/10 rounded-full text-[13px] font-bold text-white hover:border-white/20 transition-all min-w-[160px] justify-between">
                                <span>{{ ucfirst($activeSort) }}</span>
                                <svg class="w-4 h-4 text-white/30" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute top-full right-0 mt-3 w-48 bg-[#161b22] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50 py-2" style="display: none;">
                                <button wire:click="setSort('newest')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $activeSort === 'newest' ? 'text-blue-500' : 'text-white/60' }}">Newest</button>
                                <button wire:click="setSort('views')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $activeSort === 'views' ? 'text-blue-500' : 'text-white/60' }}">Most Popular</button>
                                <button wire:click="setSort('relevance')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $activeSort === 'relevance' ? 'text-blue-500' : 'text-white/60' }}">Trending</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rankings Table -->
        <div class="relative bg-transparent border-t border-white/5 mb-40">
            <div wire:loading class="absolute inset-0 bg-[#0d1117]/60 backdrop-blur-sm z-20 flex items-center justify-center">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-12 h-12 border-4 border-blue-500/10 border-t-blue-500 rounded-full animate-spin"></div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b border-white/5">
                            <th class="py-8 px-6 text-[12px] font-black text-white/20 uppercase tracking-[0.2em] w-[20%]">Title</th>
                            <th class="py-8 px-6 text-[12px] font-black text-white/20 uppercase tracking-[0.2em] w-[10%]">Type</th>
                            <th class="py-8 px-6 text-[12px] font-black text-white/20 uppercase tracking-[0.2em] w-[30%]">Description</th>
                            <th class="py-8 px-6 text-[12px] font-black text-white/20 uppercase tracking-[0.2em] w-[15%]">Metrics Row</th>
                            <th class="py-8 px-6 text-[12px] font-black text-white/20 uppercase tracking-[0.2em] w-[10%]">Contributor</th>
                            <th class="py-8 px-6 text-[12px] font-black text-white/20 uppercase tracking-[0.2em] w-[15%]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($rankings as $item)
                        <tr class="group hover:bg-white/[0.02] transition-all">
                            <td class="py-8 px-6">
                                <div class="text-[16px] font-black text-white uppercase tracking-tighter group-hover:text-blue-500 transition-colors">
                                    {{ $item['title'] }}
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="text-[12px] font-bold text-white/40 uppercase tracking-widest">
                                    {{ $item['cat'] }}
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="text-[14px] font-medium text-white/40 leading-relaxed max-w-sm line-clamp-2">
                                    {{ $item['description'] ?: 'No detailed classification record available for this entry.' }}
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="flex flex-wrap items-center gap-4">
                                    <div class="flex items-center gap-2 text-white/60">
                                        <svg class="w-4 h-4 opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-[13px] font-bold">{{ $item['reach'] }}</span>
                                    </div>
                                    <div class="px-2 py-0.5 rounded bg-white/5 text-[10px] font-black text-blue-400 uppercase tracking-widest">
                                        SEO: {{ rand(85, 98) }}
                                    </div>
                                    <div class="text-[10px] font-bold text-white/20 uppercase tracking-widest">
                                        High Activity
                                    </div>
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="text-[13px] font-bold text-white/60">
                                    {{ $item['user'] }}
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="flex items-center gap-6">
                                    <a href="{{ route('wiki.show', $item['slug']) }}" class="flex items-center gap-3 bg-white hover:bg-gray-100 px-6 py-2 rounded-full transition-all group/btn shadow-xl shadow-white/5">
                                        <span class="text-[#0d1117] text-[12px] font-black uppercase tracking-widest">View</span>
                                        <div class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                        </div>
                                    </a>
                                    <button class="text-white/20 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

