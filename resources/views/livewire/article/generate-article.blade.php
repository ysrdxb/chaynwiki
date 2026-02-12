<div class="min-h-screen bg-[#0d1117] flex justify-center" x-data="{ loaded: true }">
    @php
        $categories = [
            'artist' => ['label' => 'Artists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            'song' => ['label' => 'Songs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
            'genre' => ['label' => 'Genres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
            'playlist' => ['label' => 'Playlists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
            'term' => ['label' => 'Terminology', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
        ];
    @endphp
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-32 pb-16">
        
        <!-- Sidebar Navigation -->
        <aside class="hidden lg:block w-64 sticky top-32 shrink-0 space-y-2">
            <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </a>

            <div class="h-px bg-white/5 mx-4 my-2"></div>

            <a href="{{ route('admin.articles.generate') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold bg-[#161b22] border border-white/5 text-white transition-all shadow-lg shadow-blue-500/10">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                AI Generator
            </a>

            <a href="{{ route('wiki.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all text-white/50 hover:text-white hover:bg-white/5">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                All Records
            </a>
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all text-white/50 hover:text-white hover:bg-white/5">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                    {{ $cat['label'] }}
                </a>
            @endforeach
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             
             <!-- Header -->
             <div class="mb-12">
                 <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full text-[10px] font-black uppercase tracking-widest text-blue-400 mb-6 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    AI Assistant Ready
                 </div>
                 <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none mb-6">
                     AI <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">Generator</span>
                 </h1>
                 <p class="text-slate-400 text-lg font-medium max-w-2xl leading-relaxed">
                     Deploy our advanced neural network to synthesize comprehensive musical insights, historical context, and technical analysis in seconds.
                 </p>
             </div>

             <!-- Ollama Status -->
            @if(!$ollamaAvailable)
            <div class="bg-red-500/5 border border-red-500/20 rounded-[24px] p-6 mb-12 flex items-start gap-4 backdrop-blur-md">
                <div class="w-10 h-10 rounded-full bg-red-400/10 flex items-center justify-center shrink-0 shadow-lg shadow-red-500/10">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-red-400 font-bold mb-1 uppercase tracking-wider text-sm">Ollama Disconnected</h3>
                    <p class="text-white/50 text-xs mb-3">The neural engine requires a local Ollama instance.</p>
                    <div class="text-[10px] font-mono bg-black/40 border border-white/5 rounded-lg p-3 text-white/60 mb-3 space-y-1">
                        <div>1. Install: <span class="text-blue-400">ollama.com</span></div>
                        <div>2. Terminal: <span class="text-green-400">ollama pull llama3</span></div>
                    </div>
                    <button wire:click="checkOllama" class="text-xs font-bold text-red-400 hover:text-white transition-colors uppercase tracking-widest border-b border-red-400/30 hover:border-white">
                        Retry Connection
                    </button>
                </div>
            </div>
            @endif

            <!-- Generation Form -->
            <div class="relative group mb-12">
                <div class="absolute -inset-1 bg-gradient-to-br from-blue-500/20 via-purple-500/5 to-transparent rounded-[2.5rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                <div class="relative bg-[#161b22]/80 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 md:p-10 shadow-2xl">
                    <form wire:submit="generate" class="space-y-10">
                        
                        <!-- Topic -->
                        <div class="space-y-4">
                             <label for="topic" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/40">
                                <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Research Subject
                            </label>
                             <div class="relative group/input">
                                <input
                                    type="text"
                                    id="topic"
                                    wire:model="topic"
                                    placeholder="Enter a topic, artist name, or musical concept..."
                                    class="w-full bg-[#0d1117] border border-white/10 rounded-xl px-6 py-6 text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-lg font-bold shadow-inner"
                                    @if(!$ollamaAvailable) disabled @endif
                                />
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-white/20 group-focus-within/input:text-blue-400 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                            </div>
                            @error('topic')
                                <div class="text-[11px] text-red-400 font-bold flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-white/40">
                                Model Parameter Tuning
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($categories as $key => $cat)
                                    <label class="relative cursor-pointer group/label">
                                        <input
                                            type="radio"
                                            name="category"
                                            value="{{ $key }}"
                                            wire:model="category"
                                            class="peer sr-only"
                                            @if(!$ollamaAvailable) disabled @endif
                                        />
                                        <div class="bg-[#0d1117] border border-white/10 rounded-xl px-4 py-4 flex flex-col items-center gap-3 text-white/40 peer-checked:border-blue-500/50 peer-checked:bg-blue-500/10 peer-checked:text-white group-hover/label:border-white/20 transition-all h-full">
                                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center peer-checked:bg-blue-500/20 peer-checked:text-blue-400 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                                            </div>
                                            <span class="text-xs font-bold uppercase tracking-widest text-center">{{ $cat['label'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Button -->
                         <button
                            type="submit"
                            class="w-full relative overflow-hidden group/btn bg-white hover:bg-gray-100 text-black py-5 rounded-xl font-black uppercase tracking-widest transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(255,255,255,0.2)] hover:-translate-y-0.5 active:scale-95"
                            @if(!$ollamaAvailable || $isGenerating) disabled @endif
                        >
                            <div class="relative z-10 flex items-center justify-center gap-3">
                                @if($isGenerating)
                                    <svg class="animate-spin w-5 h-5 text-black" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                    <span>Generating Neural Map...</span>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    <span>Create Topic</span>
                                @endif
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Error -->
            @if($error)
                <div class="bg-red-500/10 border-l-4 border-red-500 p-6 mb-8 rounded-r-xl backdrop-blur-md">
                    <div class="flex items-center gap-3 text-red-100">
                        <span class="font-bold uppercase tracking-wider text-xs">System Alert:</span>
                        <span>{{ $error }}</span>
                    </div>
                </div>
            @endif

            <!-- Result -->
            @if($generatedDraft)
                <div class="bg-[#161b22] border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl relative animate-in fade-in slide-in-from-bottom-8 duration-700">
                    <!-- Result Toolbar -->
                    <div class="bg-[#0d1117] border-b border-white/5 px-8 py-5 flex items-center justify-between">
                         <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse shadow-[0_0_10px_#22c55e]"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-white uppercase tracking-widest leading-none mb-0.5">Output Ready</span>
                                <span class="text-[9px] text-white/40 font-mono">NEURAL-HASH: {{ substr(md5($generatedDraft['title']), 0, 8) }}</span>
                            </div>
                         </div>
                         <div class="flex items-center gap-4">
                             <button wire:click="regenerate" class="text-xs font-bold text-white/40 hover:text-white uppercase tracking-wider transition-colors">Regenerate</button>
                             <button wire:click="clear" class="text-xs font-bold text-red-400 hover:text-red-300 uppercase tracking-wider transition-colors">Discard</button>
                         </div>
                    </div>

                    <div class="p-10 space-y-8">
                        <div>
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-2">Proposed Title</span>
                            <h2 class="text-3xl font-black text-white tracking-tighter">{{ $generatedDraft['title'] }}</h2>
                        </div>
                        
                        <!-- Neural Tags -->
                        @if(!empty($generatedDraft['tags']))
                            <div>
                                <span class="text-[9px] font-black text-purple-400 uppercase tracking-[0.2em] block mb-3 flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    Neural Connections
                                </span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($generatedDraft['tags'] as $tag)
                                        <span class="px-3 py-1 bg-purple-500/10 border border-purple-500/20 text-purple-300 rounded-lg text-xs font-bold uppercase tracking-wide">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div>
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-4">Content Draft</span>
                            <div class="bg-[#0d1117] rounded-2xl p-8 border border-white/5 prose prose-invert prose-lg max-w-none prose-headings:font-black prose-headings:uppercase prose-headings:tracking-tight prose-headings:text-white prose-p:text-slate-400 prose-a:text-blue-400 prose-strong:text-white">
                                {!! \Illuminate\Support\Str::markdown($generatedDraft['content']) !!}
                            </div>
                        </div>

                         <button 
                            wire:click="useAsDraft"
                            class="w-full py-5 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 flex items-center justify-center gap-3 hover:-translate-y-0.5 active:scale-95"
                        >
                            <span>Publish to Wiki</span>
                            <svg class="w-4 h-4 arrow-right" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            @endif

        </main>
    </div>
</div>

