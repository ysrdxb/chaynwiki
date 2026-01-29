<div class="min-h-screen bg-[#050511] py-12 pt-32">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-600/20 text-purple-400 text-xs font-mono uppercase tracking-widest mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
                AI Analysis
            </div>
            <h1 class="text-4xl md:text-5xl font-display font-black text-white uppercase tracking-tight mb-4">
                Lyric Analyzer
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto">
                AI-powered analysis of themes, mood, rhyme schemes, and literary devices.
            </p>
        </div>

        {{-- Ollama Status --}}
        @if(!$ollamaAvailable)
            <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-red-400 font-bold mb-1">AI Service Offline</h3>
                        <p class="text-red-300/70 text-sm">Start Ollama to enable lyric analysis.</p>
                        <button wire:click="checkOllama" class="mt-2 text-xs text-red-400 hover:text-red-300 underline">Retry</button>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-8">
            {{-- Input Panel --}}
            <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4">Paste Lyrics</h2>
                <form wire:submit="analyze">
                    <textarea
                        wire:model="lyrics"
                        rows="16"
                        placeholder="Paste song lyrics here..."
                        class="w-full bg-black/30 border border-white/10 rounded-xl p-4 text-white placeholder-gray-500 text-sm font-mono resize-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all"
                        @if(!$ollamaAvailable) disabled @endif
                    ></textarea>
                    @error('lyrics')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center gap-4 mt-4">
                        <button
                            type="submit"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl transition-all disabled:opacity-50"
                            @if(!$ollamaAvailable || $isAnalyzing) disabled @endif
                        >
                            @if($isAnalyzing)
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                <span>Analyzing...</span>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <span>Analyze Lyrics</span>
                            @endif
                        </button>
                        @if($analysis)
                            <button type="button" wire:click="clear" class="px-4 py-3 bg-white/5 hover:bg-white/10 text-gray-300 rounded-xl transition-all">
                                Clear
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Results Panel --}}
            <div class="space-y-6">
                @if($error)
                    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4 text-red-400">
                        {{ $error }}
                    </div>
                @endif

                @if($analysis)
                    {{-- Mood Card --}}
                    <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                        <h3 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">Mood Analysis</h3>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl" style="background: {{ $analysis['mood'] ? match(strtolower($analysis['mood'])) { 'happy' => '#10B981', 'sad' => '#3B82F6', 'aggressive' => '#EF4444', 'calm' => '#06B6D4', default => '#8B5CF6' } : '#6B7280' }}20;">
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
                                <div class="text-2xl font-bold text-white capitalize">{{ $analysis['mood'] ?? 'Unknown' }}</div>
                                <div class="text-gray-400 text-sm">Intensity: {{ $analysis['mood_score'] ?? 5 }}/10</div>
                            </div>
                        </div>
                        <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500 transition-all" style="width: {{ ($analysis['mood_score'] ?? 5) * 10 }}%"></div>
                        </div>
                    </div>

                    {{-- Themes --}}
                    @if(!empty($analysis['themes']))
                        <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                            <h3 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">Themes</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($analysis['themes'] as $theme)
                                    <span class="px-3 py-1.5 bg-purple-500/20 text-purple-300 rounded-full text-sm">
                                        {{ $theme }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Rhyme Scheme --}}
                    <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                        <h3 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">Rhyme Scheme</h3>
                        <div class="text-3xl font-mono font-bold text-white tracking-widest mb-4">
                            {{ $analysis['rhyme_scheme'] ?? 'Unknown' }}
                        </div>
                        @if(!empty($analysis['rhyme_visualization']))
                            <div class="space-y-1 max-h-48 overflow-y-auto">
                                @foreach(array_slice($analysis['rhyme_visualization'], 0, 12) as $line)
                                    <div class="flex items-center gap-2 text-sm">
                                        <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-mono font-bold text-white" style="background: {{ $line['color'] }};">
                                            {{ $line['letter'] }}
                                        </span>
                                        <span class="text-gray-400 truncate">{{ \Illuminate\Support\Str::limit($line['line'], 50) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Literary Devices --}}
                    @if(!empty($analysis['literary_devices']))
                        <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                            <h3 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">Literary Devices</h3>
                            <div class="space-y-3">
                                @foreach(array_slice($analysis['literary_devices'], 0, 5) as $device)
                                    <div class="bg-black/30 rounded-xl p-3">
                                        <div class="text-sm font-bold text-purple-400 capitalize">{{ $device['type'] ?? 'Unknown' }}</div>
                                        <div class="text-gray-400 text-sm mt-1">"{{ $device['example'] ?? '' }}"</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Summary --}}
                    @if(!empty($analysis['summary']))
                        <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                            <h3 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">Summary</h3>
                            <p class="text-gray-300 leading-relaxed">{{ $analysis['summary'] }}</p>
                        </div>
                    @endif

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-[#0A0A14] border border-white/10 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ $analysis['word_count'] ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Words</div>
                        </div>
                        <div class="bg-[#0A0A14] border border-white/10 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ $analysis['line_count'] ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Lines</div>
                        </div>
                        <div class="bg-[#0A0A14] border border-white/10 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ $analysis['unique_words'] ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Unique</div>
                        </div>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-12 text-center">
                        <div class="w-20 h-20 rounded-full bg-purple-500/10 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Analysis Yet</h3>
                        <p class="text-gray-400">Paste lyrics and click analyze to get started.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
