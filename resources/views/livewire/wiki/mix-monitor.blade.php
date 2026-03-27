<div class="relative py-12 px-8 bg-[#0d1117] border border-white/5 rounded-[40px] overflow-hidden group mb-16">
    {{-- Background Effects --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-bl from-cyan-600/10 via-purple-600/5 to-transparent rounded-full blur-[100px] opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-emerald-500/5 rounded-full blur-[80px]"></div>
    </div>

    <div class="relative z-10">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-[32px] font-black text-white uppercase tracking-tighter leading-none mb-1 flex items-center gap-3">
                    <span class="w-2 h-8 bg-gradient-to-b from-cyan-400 to-blue-500 rounded-full"></span>
                    Sync Lab
                </h2>
                <p class="text-white/30 text-xs font-bold uppercase tracking-widest pl-5">Harmonic Mix Compatibility Engine</p>
            </div>
            
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-white/5 rounded-full border border-white/10">
                <div class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></div>
                <span class="text-[10px] font-black text-white uppercase tracking-widest">Live Analysis</span>
            </div>
        </div>

        {{-- Mix Interface --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            
            {{-- Slot A (Fixed) --}}
            <div class="relative group/slot">
                <div class="aspect-square rounded-[32px] overflow-hidden border border-white/10 relative">
                    <img src="{{ $rootArticle->featured_image }}" class="w-full h-full object-cover opacity-80 group-hover/slot:opacity-100 transition-opacity">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-8">
                        <div class="flex items-center gap-3 mb-2">
                             <span class="px-2 py-1 bg-cyan-500 text-black text-[10px] font-black uppercase tracking-widest rounded-md">Deck A</span>
                        </div>
                        <h3 class="text-white font-black text-2xl uppercase tracking-tight leading-none mb-1">{{ $rootArticle->title }}</h3>
                        <p class="text-white/50 text-xs font-bold uppercase tracking-widest">{{ $rootArticle->meta['bpm'] ?? 'N/A' }} BPM • {{ $rootArticle->meta['camelot_key'] ?? 'N/A' }}</p>
                    </div>
                </div>
                
                {{-- Connector Line (Desktop) --}}
                <div class="hidden lg:block absolute top-1/2 -right-8 w-16 h-0.5 bg-gradient-to-r from-cyan-500/50 to-transparent z-20"></div>
            </div>

            {{-- Analysis Center (Middle) --}}
            <div class="flex flex-col items-center justify-center space-y-8 relative py-8 lg:py-0">
                
                @if(!$candidateArticle)
                    <div class="w-full max-w-sm relative z-50">
                        <label class="text-white/40 text-[10px] font-bold uppercase tracking-widest mb-2 block text-center">Load Track B to Analyze</label>
                        <div class="relative group/search">
                            <input wire:model.live.debounce.300ms="searchQuery" type="text" placeholder="Search track library..." 
                                class="w-full bg-[#161b22] border border-white/10 rounded-full px-6 py-4 text-white text-sm placeholder:text-white/20 focus:border-cyan-500/50 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none text-center font-bold tracking-wide">
                            
                            {{-- Autocomplete Results --}}
                            @if(!empty($searchResults))
                                <div class="absolute top-full left-0 right-0 mt-2 bg-[#161b22] border border-white/10 rounded-2xl overflow-hidden shadow-2xl z-50">
                                    @foreach($searchResults as $result)
                                        <button wire:click="selectCandidate({{ $result->id }})" class="w-full px-4 py-3 text-left hover:bg-white/5 flex items-center gap-3 transition-colors border-b border-white/5 last:border-0">
                                            <img src="{{ $result->featured_image }}" class="w-8 h-8 rounded bg-white/10 object-cover">
                                            <div>
                                                <h4 class="text-white font-bold text-xs uppercase tracking-tight">{{ $result->title }}</h4>
                                                <p class="text-white/30 text-[9px] uppercase tracking-widest">{{ $result->meta['bpm'] ?? '?' }} BPM • {{ $result->meta['camelot_key'] ?? '?' }}</p>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Neutral State Icon --}}
                    <div class="w-24 h-24 rounded-full border-2 border-white/5 flex items-center justify-center animate-pulse mt-8">
                        <svg class="w-8 h-8 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>

                @else
                    {{-- Analysis Results --}}
                    <div class="flex flex-col items-center animate-in fade-in zoom-in duration-500">
                        {{-- Gauge --}}
                        <div class="relative w-40 h-40 flex items-center justify-center mb-6">
                            {{-- Circular Progress --}}
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/5" />
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="8" fill="transparent" class="{{ $mixData['color'] }}" stroke-dasharray="440" stroke-dashoffset="{{ 440 - (440 * ($mixData['harmonic_score'] / 100)) }}" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                <span class="text-3xl font-black text-white tracking-tighter">{{ $mixData['harmonic_score'] }}%</span>
                                <span class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Match</span>
                            </div>
                        </div>

                        {{-- Verdict --}}
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-1">{{ $mixData['harmonic_status'] }}</h3>
                        
                        {{-- Pitch Shift Stats --}}
                        <div class="flex items-center gap-4 mt-4 text-[10px] font-bold uppercase tracking-widest text-white/50">
                            <div>
                                BPM Diff: <span class="text-white">{{ $mixData['bpm_diff'] > 0 ? '+' : '' }}{{ $mixData['bpm_diff'] }}</span>
                            </div>
                            <div class="w-1 h-1 bg-white/20 rounded-full"></div>
                            <div>
                                Pitch: <span class="{{ abs($mixData['bpm_percent']) > 6 ? 'text-red-400' : 'text-green-400' }}">{{ $mixData['bpm_percent'] }}%</span>
                            </div>
                        </div>

                        <button wire:click="$set('candidateArticle', null)" class="mt-8 text-xs text-white/30 hover:text-white underline decoration-white/10 hover:decoration-white transition-all uppercase font-bold tracking-widest">
                            Reset Decks
                        </button>
                    </div>
                @endif
            </div>

            {{-- Slot B (Variable) --}}
            <div class="relative group/slot h-full flex flex-col">
                 @if($candidateArticle)
                    <div class="aspect-square rounded-[32px] overflow-hidden border border-white/10 relative animate-in slide-in-from-right-8 duration-500">
                        <img src="{{ $candidateArticle->featured_image }}" class="w-full h-full object-cover opacity-80 group-hover/slot:opacity-100 transition-opacity">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-8">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-2 py-1 bg-purple-500 text-white text-[10px] font-black uppercase tracking-widest rounded-md">Deck B</span>
                            </div>
                            <h3 class="text-white font-black text-2xl uppercase tracking-tight leading-none mb-1">{{ $candidateArticle->title }}</h3>
                            <p class="text-white/50 text-xs font-bold uppercase tracking-widest">{{ $candidateArticle->meta['bpm'] ?? 'N/A' }} BPM • {{ $candidateArticle->meta['camelot_key'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                 @else
                    {{-- Empty State --}}
                    <div class="aspect-square rounded-[32px] border-2 border-white/5 border-dashed flex flex-col items-center justify-center group-hover/slot:border-white/10 transition-colors bg-white/[0.02]">
                        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="text-white/20 text-xs font-bold uppercase tracking-widest">Empty Slot</span>
                    </div>
                 @endif

                 {{-- Connector Line (Desktop) --}}
                <div class="hidden lg:block absolute top-1/2 -left-8 w-16 h-0.5 bg-gradient-to-l from-purple-500/50 to-transparent z-20"></div>
            </div>
            
        </div>
    </div>
</div>
