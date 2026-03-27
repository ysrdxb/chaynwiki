<div class="relative py-12 px-8 bg-[#0d1117] border border-white/5 rounded-[40px] overflow-hidden group">
    
    {{-- Background Effects --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-bl from-blue-600/10 via-purple-600/5 to-transparent rounded-full blur-[100px] opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-emerald-500/5 rounded-full blur-[80px]"></div>
    </div>

    <div class="relative z-10">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-[32px] font-black text-white uppercase tracking-tighter leading-none mb-1 flex items-center gap-3">
                    <span class="w-2 h-8 bg-gradient-to-b from-blue-400 to-purple-500 rounded-full"></span>
                    The Vault
                </h2>
                <p class="text-white/30 text-xs font-bold uppercase tracking-widest pl-5">Collection Analytics & Valuation</p>
            </div>
            
            <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-full border border-white/10">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-black text-white uppercase tracking-widest">Live Valuation</span>
            </div>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            
            {{-- Metric 1: Total Value --}}
            <div class="bg-[#161b22]/80 backdrop-blur-md p-8 rounded-[32px] border border-white/5 group-hover:border-white/10 transition-colors relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-white/40 text-[11px] font-black uppercase tracking-widest mb-4">Cultural Value</h3>
                <div class="text-[42px] font-black text-white tracking-tighter flex items-baseline gap-1">
                    <span class="text-[20px] text-blue-500">$</span>
                    {{ number_format($totalValue) }}
                </div>
                <div class="mt-2 text-emerald-400 text-[10px] font-bold uppercase tracking-widest flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    +12% This Month
                </div>
            </div>

            {{-- Metric 2: Rarity Score --}}
            <div class="bg-[#161b22]/80 backdrop-blur-md p-8 rounded-[32px] border border-white/5 group-hover:border-white/10 transition-colors relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 class="text-white/40 text-[11px] font-black uppercase tracking-widest mb-4">Rarity Grade</h3>
                <div class="text-[42px] font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500 tracking-tighter">
                    {{ $rarityScore }}<span class="text-[20px] text-white/20">/100</span>
                </div>
                <div class="mt-2 text-white/30 text-[10px] font-bold uppercase tracking-widest">
                    Based on global scarcity
                </div>
            </div>

            {{-- Metric 3: Items --}}
            <div class="bg-[#161b22]/80 backdrop-blur-md p-8 rounded-[32px] border border-white/5 group-hover:border-white/10 transition-colors relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-white/40 text-[11px] font-black uppercase tracking-widest mb-4">Artifacts Stored</h3>
                <div class="text-[42px] font-black text-white tracking-tighter">
                    {{ number_format($itemsCount) }}
                </div>
                <div class="mt-2 text-blue-400 text-[10px] font-bold uppercase tracking-widest">
                    Across {{ Auth::user()->crates->count() }} Collections
                </div>
            </div>
        </div>

        {{-- Top Gems --}}
        @if(count($topGems) > 0)
        <div>
            <h3 class="text-white/40 text-[11px] font-black uppercase tracking-widest mb-6 border-b border-white/5 pb-2">Crown Jewels</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($topGems as $gem)
                    <a href="{{ route('wiki.show', $gem) }}" class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-colors group/gem">
                        <div class="w-12 h-12 rounded-lg bg-black/50 overflow-hidden relative border border-white/10">
                            <img src="{{ $gem->featured_image }}" class="w-full h-full object-cover group-hover/gem:scale-110 transition-transform duration-500">
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm leading-tight mb-1 group-hover/gem:text-blue-400 transition-colors line-clamp-1">{{ $gem->title }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="text-[9px] font-black text-yellow-500 uppercase tracking-widest border border-yellow-500/20 px-1 py-0.5 rounded">R{{ $gem->trust_score }}</span>
                                <span class="text-[9px] text-white/30 font-bold">{{ $gem->category }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
