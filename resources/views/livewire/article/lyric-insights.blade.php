<div class="glass border-white/10 rounded-[2.5rem] overflow-hidden group shadow-3xl">
    <div class="p-10 lg:p-12">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-brand-500/10 rounded-2xl flex items-center justify-center border border-brand-500/20">
                    <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-display font-black text-white uppercase tracking-tight">Lyric Intelligence</h3>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] mt-1 italic">Distributed Neural Analysis // v4.0</p>
                </div>
            </div>
            
            @if(!$analysis && !$isAnalyzing)
                <button 
                    wire:click="analyze"
                    class="px-8 py-4 bg-brand-500 hover:bg-brand-400 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-2xl shadow-brand-500/20 flex items-center gap-3 hover:scale-105 active:scale-95"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    </svg>
                    Initiate Analysis
                </button>
            @endif
        </div>

        @if($isAnalyzing)
            <div class="py-20 flex flex-col items-center justify-center text-center">
                <div class="relative w-24 h-24 mb-10">
                    <div class="absolute inset-0 border-2 border-brand-500/10 rounded-full scale-150"></div>
                    <div class="absolute inset-0 border-4 border-brand-500 border-t-transparent rounded-full animate-spin"></div>
                    <div class="absolute inset-4 bg-brand-500/5 rounded-full animate-pulse flex items-center justify-center border border-brand-500/20">
                        <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <h4 class="text-xl font-display font-black text-white mb-3 uppercase tracking-widest">Decoding Signal...</h4>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] max-w-sm leading-relaxed">Extracting thematic anchors and harmonic structures from lyrical payload.</p>
            </div>
        @elseif($analysis)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Left Column: Interpretation & Mood -->
                <div class="space-y-12">
                    <!-- Summary -->
                    <div>
                        <div class="text-[10px] font-black uppercase text-brand-500 tracking-[0.4em] mb-6">Semantic Interpretation</div>
                        <div class="glass p-8 rounded-[2rem] border-white/5 bg-white/[0.01]">
                            <p class="text-xl text-slate-300 leading-relaxed font-medium italic">
                                "{{ $analysis['summary'] ?? 'Metadata analysis yielded no summary.' }}"
                            </p>
                        </div>
                    </div>

                    <!-- Mood Intensity -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-[10px] font-black uppercase text-brand-500 tracking-[0.4em]">Intensity Index</div>
                            <span class="px-4 py-1 bg-brand-500/10 text-brand-500 border border-brand-500/20 rounded-full text-[9px] uppercase font-black tracking-widest">
                                {{ $analysis['mood'] ?? 'Stable' }}
                            </span>
                        </div>
                        <div class="relative h-3 bg-white/5 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent animate-pulse"></div>
                            <div 
                                class="absolute top-0 left-0 h-full bg-gradient-to-r from-brand-600 via-brand-400 to-purple-500 rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ ($analysis['mood_score'] ?? 5) * 10 }}%"
                            ></div>
                        </div>
                        <div class="flex justify-between mt-4 text-[9px] text-slate-500 font-black uppercase tracking-widest">
                            <span>Base Line</span>
                            <span class="text-white">Magnitude: {{ $analysis['mood_score'] ?? 5 }}.0</span>
                            <span>Peak Signal</span>
                        </div>
                    </div>

                    <!-- Thematic Nodes -->
                    <div>
                        <div class="text-[10px] font-black uppercase text-brand-500 tracking-[0.4em] mb-6">Thematic Clustors</div>
                        <div class="flex flex-wrap gap-4">
                            @foreach($analysis['themes'] ?? [] as $theme)
                                <span class="px-6 py-2.5 glass border border-white/5 rounded-xl text-[10px] font-black text-slate-300 uppercase tracking-widest hover:border-brand-500/30 transition-all cursor-crosshair">
                                    {{ $theme }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column: Technical Grid -->
                <div class="space-y-12">
                    <!-- Rhyme Flow -->
                    <div>
                        <div class="text-[10px] font-black uppercase text-brand-500 tracking-[0.4em] mb-6">Harmonic Visualization</div>
                        <div class="space-y-3 max-h-[220px] overflow-y-auto pr-4 custom-scrollbar">
                            @foreach($analysis['rhyme_visualization'] ?? [] as $rhyme)
                                <div class="flex items-center gap-4 group cursor-pointer">
                                    <div class="w-1.5 h-8 rounded-full flex-shrink-0 transition-opacity group-hover:opacity-100 opacity-40" style="background-color: {{ $rhyme['color'] }}"></div>
                                    <div class="text-[11px] font-bold text-slate-500 group-hover:text-white transition uppercase tracking-tight">{{ $rhyme['line'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 flex items-center gap-3">
                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Schematic:</span>
                            <span class="text-[10px] font-black text-brand-500 uppercase tracking-[0.2em] px-3 py-1 bg-brand-500/5 border border-brand-500/10 rounded">{{ $analysis['rhyme_scheme'] ?? 'Complex Flux' }}</span>
                        </div>
                    </div>

                    <!-- Literary Devices -->
                    <div>
                        <div class="text-[10px] font-black uppercase text-brand-500 tracking-[0.4em] mb-6">Rhetorical Devices</div>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach(array_slice($analysis['literary_devices'] ?? [], 0, 2) as $device)
                                <div class="p-6 glass border border-white/5 rounded-2xl group hover:bg-white/[0.02] transition-colors">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ $device['type'] }}</span>
                                        <span class="text-[8px] text-slate-600 font-black uppercase tracking-[0.2em]">Node Path: {{ $device['line'] ?? '??' }}</span>
                                    </div>
                                    <p class="text-sm text-slate-400 italic font-medium leading-relaxed">"{{ $device['example'] }}"</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Analysis Log Footer -->
            <div class="mt-16 pt-10 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Probabilistic Tags:</div>
                    <div class="flex gap-3">
                        @foreach(array_slice($analysis['genre_hints'] ?? [], 0, 3) as $hint)
                            <span class="text-[9px] font-black text-slate-400 bg-white/5 border border-white/5 px-3 py-1 rounded-[10px] uppercase tracking-widest">{{ $hint }}</span>
                        @endforeach
                    </div>
                </div>
                <button wire:click="analyze" class="text-[9px] font-black text-slate-500 hover:text-brand-500 flex items-center gap-2 transition uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Re-scan Payload
                </button>
            </div>
        @endif
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.1); }
</style>
