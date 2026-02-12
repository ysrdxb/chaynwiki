@extends('layouts.app')

@section('title', $article->title . ' - Record Label Archive')

@section('content')
<div class="min-h-screen bg-[#0d1117]">
    {{-- Hero Section --}}
    <div class="relative pt-32 pb-20 px-8 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/10 via-transparent to-transparent opacity-50"></div>
        
        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="flex flex-col md:flex-row items-end gap-12">
                {{-- Label Logo/Image --}}
                <div class="w-64 h-64 rounded-[2.5rem] overflow-hidden border border-white/10 shadow-3xl group relative">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-lg text-[10px] font-black uppercase tracking-widest text-emerald-400 backdrop-blur-md">Collection Archive</span>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[10px] font-black uppercase tracking-widest text-emerald-400 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Record Label / Studio
                        </div>
                        @if($article->is_master)
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full text-[10px] font-black uppercase tracking-widest text-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.3)]">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Canonical Entity
                            </div>
                        @endif
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none mb-8">
                        {{ $article->title }}
                    </h1>
                    <div class="grid grid-cols-2 lg:flex lg:flex-wrap items-center gap-6 lg:gap-10">
                         <div class="flex flex-col">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Archive Trust</span>
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-1.5 bg-white/5 rounded-full overflow-hidden">
                                     <div class="h-full bg-emerald-500" style="width: {{ $article->data_quality }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-white uppercase tracking-widest">{{ $article->data_quality }}% Verified</span>
                            </div>
                        </div>
                        <div class="h-10 w-px bg-white/10 hidden md:block"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Roster Count</span>
                            <span class="text-2xl font-black text-white uppercase tracking-tighter">{{ count($roster) }} <span class="text-white/20">Signings</span></span>
                        </div>
                        <div class="h-10 w-px bg-white/10 hidden md:block"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Catalog Size</span>
                            <span class="text-2xl font-black text-white uppercase tracking-tighter">{{ count($catalog) }} <span class="text-white/20">Releases</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="max-w-[1200px] mx-auto px-8 pb-32">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            
            {{-- Main Column --}}
            <div class="lg:col-span-2 space-y-20">
                
                {{-- Vision/Biography --}}
                <section>
                    <h3 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                         <span class="w-8 h-px bg-emerald-500/30"></span>
                         Overview & Vision
                    </h3>
                    <div class="article-content prose prose-invert prose-emerald max-w-none text-white/70 leading-relaxed text-lg font-medium">
                        {!! \Illuminate\Support\Str::markdown($article->content) !!}
                    </div>
                </section>

                {{-- Neural Map Context --}}
                <section>
                     <h3 class="text-[10px] font-black text-purple-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                         <span class="w-8 h-px bg-purple-500/30"></span>
                         Industry Connections
                    </h3>
                    <div class="h-[500px] rounded-[3rem] overflow-hidden border border-white/5 bg-black/20 backdrop-blur-xl relative group">
                        <x-neural-map-visualization :articleId="$article->id" :height="500" />
                        <div class="absolute inset-0 pointer-events-none border border-white/5 group-hover:border-purple-500/20 transition-all rounded-[3rem]"></div>
                    </div>
                </section>

                {{-- Catalog Grid --}}
                <section>
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] flex items-center gap-3">
                            <span class="w-8 h-px bg-blue-500/30"></span>
                            Archival Catalog
                        </h3>
                        <span class="text-[10px] font-black text-white/20 uppercase tracking-widest">{{ count($catalog) }} Total Items</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($catalog as $item)
                             <a href="{{ route('wiki.show', $item->slug) }}" class="group/card relative bg-[#161b22] border border-white/5 rounded-[2rem] p-6 hover:border-blue-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/5">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden border border-white/10 group-hover/card:scale-110 transition-transform duration-500 shrink-0">
                                        <img src="{{ $item->featured_image }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-white font-black uppercase tracking-tighter leading-none group-hover/card:text-blue-400 transition-colors truncate">{{ $item->title }}</h4>
                                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mt-2 italic">Release #{{ substr(md5($item->id), 0, 6) }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full py-20 text-center border-2 border-dashed border-white/5 rounded-[3rem]">
                                <p class="text-white/20 font-black uppercase tracking-widest">No releases indexed for this label</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-12">
                
                {{-- Roster Sidebar --}}
                <div class="card-premium-unified !bg-[#161b22]/40 backdrop-blur-2xl border border-white/5 !p-10">
                     <h3 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-10">
                         Signed Artists
                    </h3>
                    <div class="space-y-6">
                        @forelse($roster as $artist)
                            <a href="{{ route('wiki.show', $artist->slug) }}" class="flex items-center gap-4 group/artist">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-white/10 group-hover/artist:border-emerald-500/50 transition-all">
                                    <img src="{{ $artist->featured_image }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[13px] font-black text-white group-hover/artist:text-emerald-400 transition-colors uppercase tracking-tight">{{ $artist->title }}</span>
                                    <span class="text-[9px] font-black text-white/20 uppercase tracking-widest mt-0.5">Primary Active</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-6">
                                <span class="text-[10px] font-black text-white/20 uppercase tracking-widest">Empty Roster</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Metadata Sidebar --}}
                <div class="card-premium-unified !bg-[#161b22]/40 backdrop-blur-2xl border border-white/5 !p-10">
                     <h3 class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-10">
                         Record Data
                    </h3>
                    <div class="space-y-8">
                         <div>
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest block mb-2">Provenance</span>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 font-black text-[10px]">
                                    {{ substr($article->user->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-bold text-white">{{ $article->user->name ?? 'System' }}</span>
                                    <span class="text-[9px] text-white/30 uppercase tracking-widest mt-0.5">Archivist</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest block mb-2">Record Hash</span>
                            <code class="text-[10px] font-mono text-white/40 tracking-tighter">{{ hash('sha256', $article->id . $article->title) }}</code>
                        </div>

                        @if($article->status === 'published')
                            <div class="p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Vault Status: Canonical</span>
                                </div>
                                <p class="text-[10px] text-white/40 leading-relaxed italic">"This entity has been verified as a primary entry in the global music network."</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
