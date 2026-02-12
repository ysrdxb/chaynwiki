<div class="min-h-screen bg-[#0d1117] py-12 pt-32">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute inset-x-0 -top-20 h-40 bg-purple-500/10 blur-[100px] opacity-20"></div>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] uppercase font-bold tracking-[0.2em] mb-6 shadow-[0_0_15px_rgba(168,85,247,0.2)]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
                Lyric intelligence
            </div>
            <h1 class="text-4xl md:text-6xl font-display font-black text-white uppercase tracking-tighter mb-6 drop-shadow-2xl">
                LYRIC <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">ANALYZER</span>
            </h1>
            <p class="text-slate-400 max-w-xl mx-auto leading-relaxed text-base font-medium">
                Deconstruct the subtext, emotional resonance, and linguistic patterns of any song using deep semantic analysis.
            </p>
        </div>

        {{-- Main Interface --}}
        <div>
            {{-- Ollama Status --}}
            @if(!$ollamaAvailable)
            <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 mb-8 backdrop-blur-md">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center shadow-lg shadow-red-500/10">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-red-400 font-bold mb-1">AI Service Offline</h3>
                        <p class="text-red-300/70 text-sm">Start Ollama to enable lyric analysis.</p>
                        <button wire:click="checkOllama" class="mt-2 text-xs text-red-400 hover:text-red-300 underline font-bold uppercase tracking-wide">Retry Connection</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-10">
                {{-- Input Panel --}}
                <div class="bg-[#161b22]/60 backdrop-blur-xl border border-white/5 rounded-[32px] p-8 shadow-2xl relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[32px] pointer-events-none"></div>
                    
                    <h2 class="text-xl font-black text-white mb-6 flex items-center gap-3 uppercase tracking-tight">
                        <span class="w-10 h-10 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 shadow-lg shadow-purple-500/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </span>
                        Lyric Source
                    </h2>
                    
                    <form wire:submit="analyze">
                        <div class="relative">
                            <textarea
                                wire:model="lyrics"
                                rows="16"
                                placeholder="Paste song lyrics here..."
                                class="w-full bg-black/20 border border-white/10 rounded-2xl p-6 text-white placeholder-white/20 text-sm font-mono leading-relaxed resize-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all shadow-inner"
                                @if(!$ollamaAvailable) disabled @endif
                            ></textarea>
                            <div class="absolute bottom-4 right-4 text-[10px] text-white/30 font-bold uppercase tracking-wider pointer-events-none">
                                Detects language automatically
                            </div>
                        </div>
                        
                        @error('lyrics')
                            <p class="mt-3 text-red-400 text-sm font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="flex items-center gap-4 mt-8">
                            <button
                                type="submit"
                                class="flex-1 flex items-center justify-center gap-3 px-8 py-4 bg-purple-600 hover:bg-purple-500 text-white font-black rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-purple-500/30 hover:shadow-purple-500/40 hover:-translate-y-0.5 active:scale-95 text-[11px] uppercase tracking-[0.15em]"
                                @if(!$ollamaAvailable || $isAnalyzing) disabled @endif
                            >
                                @if($isAnalyzing)
                                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    <span>Processing Connections...</span>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    <span>Decode Lyrics</span>
                                @endif
                            </button>
                            
                            @if($analysis)
                                <button type="button" wire:click="clear" class="px-6 py-4 bg-white/5 hover:bg-white/10 text-white/60 hover:text-white rounded-xl transition-all font-bold uppercase tracking-wider text-[11px] border border-white/5">
                                    Reset
                                </button>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Results Panel --}}
                <div class="space-y-6">
                    @if($error)
                        <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 text-red-400 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $error }}
                        </div>
                    @endif

                    @if($analysis)
                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-700 space-y-6">
                            
                            {{-- Mood Card --}}
                            <div class="bg-[#161b22]/80 backdrop-blur-xl border border-white/5 rounded-3xl p-8 relative overflow-hidden">
                                <div class="absolute top-0 right-0 p-32 bg-gradient-to-br from-{{ $analysis['mood'] ? match(strtolower($analysis['mood'])) { 'happy' => 'emerald', 'sad' => 'blue', 'aggressive' => 'red', 'calm' => 'cyan', default => 'purple' } : 'purple' }}-500/20 to-transparent rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                                
                                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-6">Emotional Resonance</h3>
                                
                                <div class="flex items-center gap-6 mb-8 relative z-10">
                                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl shadow-2xl ring-1 ring-white/10" style="background: rgba(255,255,255,0.03);">
                                        @switch(strtolower($analysis['mood'] ?? ''))
                                            @case('happy') 😊 @break
                                            @case('sad') 😢 @break
                                            @case('aggressive') 😤 @break
                                            @case('calm') 😌 @break
                                            @case('nostalgic') 🥹 @break
                                            @case('hopeful') ✨ @break
                                            @case('dark') 🌑 @break
                                            @default 🎵
                                        @endswitch
                                    </div>
                                    <div>
                                        <div class="text-3xl font-black text-white capitalize tracking-tight mb-1">{{ $analysis['mood'] ?? 'Unknown' }}</div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-white/40 text-xs font-bold uppercase tracking-wide">Intensity Level</span>
                                            <span class="px-2 py-0.5 rounded bg-white/10 text-white text-[10px] font-bold">{{ $analysis['mood_score'] ?? 5 }}/10</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 transition-all duration-1000" style="width: {{ ($analysis['mood_score'] ?? 5) * 10 }}%"></div>
                                </div>
                            </div>

                            {{-- Themes --}}
                            @if(!empty($analysis['themes']))
                                <div class="bg-[#161b22]/60 backdrop-blur-xl border border-white/5 rounded-3xl p-8">
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-6">Core Themes</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($analysis['themes'] as $theme)
                                            <span class="px-4 py-2 bg-white/5 border border-white/5 hover:bg-white/10 text-white/80 rounded-xl text-xs font-bold uppercase tracking-wide transition-all cursor-default">
                                                #{{ $theme }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Rhyme Scheme --}}
                            <div class="bg-[#161b22]/60 backdrop-blur-xl border border-white/5 rounded-3xl p-8">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40">Rhyme Architecture</h3>
                                    <div class="px-3 py-1 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs font-mono font-bold">{{ $analysis['rhyme_scheme'] ?? 'Free Verse' }}</div>
                                </div>
                                
                                @if(!empty($analysis['rhyme_visualization']))
                                    <div class="space-y-1.5 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach(array_slice($analysis['rhyme_visualization'], 0, 12) as $line)
                                            <div class="flex items-center gap-3 text-sm group hover:bg-white/[0.02] p-1.5 rounded-lg transition-colors">
                                                <span class="w-6 h-6 rounded flex items-center justify-center text-[10px] font-mono font-bold text-white shadow-sm ring-1 ring-white/5" style="background: {{ $line['color'] }};">
                                                    {{ $line['letter'] }}
                                                </span>
                                                <span class="text-slate-400 group-hover:text-slate-200 transition-colors truncate font-medium">{{ \Illuminate\Support\Str::limit($line['line'], 50) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- Stats --}}
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-[#161b22]/60 border border-white/5 rounded-2xl p-4 text-center hover:bg-white/5 transition-colors group">
                                    <div class="text-2xl font-black text-white group-hover:text-blue-400 transition-colors">{{ $analysis['word_count'] ?? 0 }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-widest text-white/30">Words</div>
                                </div>
                                <div class="bg-[#161b22]/60 border border-white/5 rounded-2xl p-4 text-center hover:bg-white/5 transition-colors group">
                                    <div class="text-2xl font-black text-white group-hover:text-purple-400 transition-colors">{{ $analysis['line_count'] ?? 0 }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-widest text-white/30">Lines</div>
                                </div>
                                <div class="bg-[#161b22]/60 border border-white/5 rounded-2xl p-4 text-center hover:bg-white/5 transition-colors group">
                                    <div class="text-2xl font-black text-white group-hover:text-pink-400 transition-colors">{{ $analysis['unique_words'] ?? 0 }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-widest text-white/30">Vocab</div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-[#161b22]/40 border border-white/5 rounded-[32px] p-16 text-center border-dashed">
                            <div class="w-24 h-24 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-8 animate-pulse text-white/20">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-white mb-2 uppercase tracking-tight">Ready to Analyze</h3>
                            <p class="text-white/40 max-w-xs mx-auto text-sm leading-relaxed">Paste lyrics on the left to uncover hidden meanings, sentiment, and rhyme patterns.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Scrollbar for Results */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.02);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>
