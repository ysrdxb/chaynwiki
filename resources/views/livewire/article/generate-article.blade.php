<div class="min-h-screen bg-[#050511] py-12 pt-32" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 800)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute inset-x-0 -top-20 h-40 bg-brand-500/10 blur-[100px] opacity-20"></div>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-[10px] uppercase font-bold tracking-[0.2em] mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                AI Co-Pilot
            </div>
            <h1 class="text-4xl md:text-6xl font-display font-black text-white uppercase tracking-tighter mb-6 drop-shadow-2xl">
                AI <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-indigo-500">GENERATOR</span>
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto leading-relaxed text-base font-medium">
                Our advanced neural network creates comprehensive musical insights, historical context, and technical analysis in seconds.
            </p>
        </div>

        {{-- Skeleton Loader --}}
        <div x-show="!loaded" class="space-y-8 animate-pulse">
            <div class="bg-[#0A0A14] border border-white/10 rounded-3xl p-10 h-80"></div>
        </div>

        {{-- Main Interface --}}
        <div x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            {{-- Ollama Status --}}
            @if(!$ollamaAvailable)
            <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-red-400 font-bold mb-1">Ollama Not Running</h3>
                        <p class="text-red-300/70 text-sm mb-3">AI generation requires Ollama to be running locally.</p>
                        <div class="text-xs font-mono bg-black/30 rounded-lg p-3 text-gray-400">
                            <div class="mb-1">1. Install Ollama: <span class="text-white">https://ollama.com/download</span></div>
                            <div class="mb-1">2. Start Ollama (runs in background)</div>
                            <div>3. Pull model: <span class="text-white">ollama pull llama3</span></div>
                        </div>
                        <button wire:click="checkOllama" class="mt-4 text-xs text-red-400 hover:text-red-300 underline">
                            Check Again
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Generation Form --}}
        <div class="bg-[#0A0A14] border border-white/10 rounded-3xl p-10 mb-12 shadow-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            <form wire:submit="generate" class="space-y-8 relative">
                {{-- Topic Input --}}
                <div class="relative">
                    <label for="topic" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-4 ml-1">
                        Topic / Subject
                    </label>
                    <div class="relative group/input">
                        <input
                            type="text"
                            id="topic"
                            wire:model="topic"
                            placeholder="e.g., The evolution of Grime music, or a Specific Artist..."
                            class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-5 text-white placeholder-gray-600 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all text-lg font-medium"
                            @if(!$ollamaAvailable) disabled @endif
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-700 peer-focus:text-brand-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                    @error('topic')
                        <p class="mt-3 text-red-500 text-xs font-mono uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category Selection --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-4 ml-1">
                        AI Model Tuning
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($categories as $key => $label)
                            <label class="relative cursor-pointer group/label">
                                <input
                                    type="radio"
                                    name="category"
                                    value="{{ $key }}"
                                    wire:model="category"
                                    class="peer sr-only"
                                    @if(!$ollamaAvailable) disabled @endif
                                />
                                <div class="bg-black/40 border border-white/10 rounded-2xl px-4 py-4 text-center text-sm font-bold text-gray-500 peer-checked:border-brand-500 peer-checked:bg-brand-500/10 peer-checked:text-brand-400 group-hover/label:border-white/20 transition-all uppercase tracking-tight">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Generate Button --}}
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full group/btn relative overflow-hidden flex items-center justify-center gap-4 px-10 py-5 bg-brand-600 hover:bg-brand-500 text-white font-black rounded-2xl transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-brand-500/20 active:scale-[0.98]"
                        @if(!$ollamaAvailable || $isGenerating) disabled @endif
                    >
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:animate-shimmer"></div>
                        
                        @if($isGenerating)
                            <svg class="animate-spin w-6 h-6" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            <span class="uppercase tracking-widest text-sm">Neural Processing...</span>
                        @else
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="uppercase tracking-[0.1em] text-sm">Forge Content</span>
                        @endif
                    </button>
                </div>
            </form>
        </div>

        {{-- Error Message --}}
        @if($error)
            <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 mb-8">
                <div class="flex items-center gap-3 text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $error }}</span>
                </div>
            </div>
        @endif

        {{-- Generated Result --}}
        @if($generatedDraft)
            <div class="bg-[#0A0A14] border border-brand-500/20 rounded-3xl overflow-hidden shadow-2xl animate-fade-in divide-y divide-white/5">
                {{-- Result Header --}}
                <div class="bg-gradient-to-r from-brand-500/10 to-indigo-500/10 px-8 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-brand-500/20 flex items-center justify-center glow-sm shadow-brand-500/30">
                            <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-black uppercase tracking-tight text-lg">Draft Synthesized</h3>
                            <p class="text-gray-500 text-[10px] font-mono uppercase tracking-widest mt-0.5">Time: {{ $generatedDraft['generation_time'] ?? '?' }}s • Engine: Llama3</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button wire:click="regenerate" class="flex-1 md:flex-none px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition-all">
                            Regenerate
                        </button>
                        <button wire:click="clear" class="p-2.5 text-gray-600 hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Title Preview --}}
                <div class="px-8 py-8">
                    <div class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-600 mb-4">Proposed Title</div>
                    <h2 class="text-3xl font-display font-black text-white italic tracking-tighter">{{ $generatedDraft['title'] }}</h2>
                </div>

                {{-- Content Preview --}}
                <div class="px-8 py-10 bg-black/20">
                    <div class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-600 mb-6">Article Preview</div>
                    <div class="prose prose-invert prose-brand max-w-none prose-p:text-gray-400 prose-p:leading-relaxed prose-headings:font-display prose-headings:italic prose-headings:tracking-tighter">
                        {!! \Illuminate\Support\Str::markdown($generatedDraft['content']) !!}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-8 py-8 bg-[#0D0D19] flex items-center justify-between">
                    <button wire:click="clear" class="text-gray-600 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                        Discard & Restart
                    </button>
                    <button 
                        wire:click="useAsDraft"
                        class="flex items-center gap-3 px-10 py-4 bg-white text-black font-black rounded-2xl hover:bg-brand-400 transition-all shadow-xl shadow-white/5 active:scale-95 text-xs uppercase tracking-widest"
                    >
                        <span>USE DRAFT</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        </div>

    </div>
</div>
