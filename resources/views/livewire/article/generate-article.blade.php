<div class="min-h-screen bg-[#050511] py-12 pt-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-600/20 text-brand-400 text-xs font-mono uppercase tracking-widest mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                AI-Powered
            </div>
            <h1 class="text-4xl md:text-5xl font-display font-black text-white uppercase tracking-tight mb-4">
                Generate Article
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto">
                Let AI create a draft article for you. Just enter a topic and category, and we'll generate comprehensive wiki content.
            </p>
        </div>

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
        <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-8 mb-8">
            <form wire:submit="generate" class="space-y-6">
                {{-- Topic Input --}}
                <div>
                    <label for="topic" class="block text-xs font-mono uppercase tracking-widest text-gray-400 mb-3">
                        Topic / Subject
                    </label>
                    <input
                        type="text"
                        id="topic"
                        wire:model="topic"
                        placeholder="e.g., Drake, Hip Hop, Bohemian Rhapsody..."
                        class="w-full bg-black/30 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-gray-500 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all"
                        @if(!$ollamaAvailable) disabled @endif
                    />
                    @error('topic')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category Selection --}}
                <div>
                    <label class="block text-xs font-mono uppercase tracking-widest text-gray-400 mb-3">
                        Category
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($categories as $key => $label)
                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="category"
                                    value="{{ $key }}"
                                    wire:model="category"
                                    class="peer sr-only"
                                    @if(!$ollamaAvailable) disabled @endif
                                />
                                <div class="bg-black/30 border border-white/10 rounded-xl px-4 py-3 text-center text-sm text-gray-400 peer-checked:border-brand-500 peer-checked:bg-brand-500/10 peer-checked:text-brand-400 hover:border-white/20 transition-all">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Generate Button --}}
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    @if(!$ollamaAvailable || $isGenerating) disabled @endif
                >
                    @if($isGenerating)
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                        <span>Generating... This may take a minute</span>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Generate Article</span>
                    @endif
                </button>
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
            <div class="bg-[#0A0A14] border border-white/10 rounded-2xl overflow-hidden">
                {{-- Result Header --}}
                <div class="bg-green-500/10 border-b border-white/10 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold">Article Generated!</h3>
                            <p class="text-gray-400 text-xs">Generated in {{ $generatedDraft['generation_time'] ?? '?' }}s</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button wire:click="regenerate" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 rounded-lg text-sm transition-all">
                            Regenerate
                        </button>
                        <button wire:click="clear" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 rounded-lg text-sm transition-all">
                            Clear
                        </button>
                    </div>
                </div>

                {{-- Title Preview --}}
                <div class="px-6 py-4 border-b border-white/10">
                    <div class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-2">Title</div>
                    <h2 class="text-2xl font-display font-bold text-white">{{ $generatedDraft['title'] }}</h2>
                </div>

                {{-- Content Preview --}}
                <div class="px-6 py-6">
                    <div class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-4">Content Preview</div>
                    <div class="prose prose-invert prose-sm max-w-none">
                        {!! \Illuminate\Support\Str::markdown($generatedDraft['content']) !!}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 py-4 bg-black/30 border-t border-white/10 flex items-center justify-between">
                    <button wire:click="clear" class="text-gray-400 hover:text-white transition-all text-sm">
                        Start Over
                    </button>
                    <button 
                        wire:click="useAsDraft"
                        class="flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl transition-all"
                    >
                        <span>Use as Draft</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

    </div>
</div>
