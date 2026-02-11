@extends('layouts.wiki')

@section('title', 'Neural Discovery Map - ChaynWiki')

@section('content')
<div class="min-h-screen bg-[#0d1117] pt-24 overflow-hidden flex flex-col">
    {{-- Fullscreen Header --}}
    <div class="px-8 py-6 border-b border-white/5 bg-[#0d1117]/80 backdrop-blur-xl relative z-20">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 shadow-lg shadow-purple-500/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-white tracking-tighter uppercase" style="font-family: 'Moderniz', sans-serif;">
                        Neural <span class="text-purple-500">Discovery</span> Map
                    </h1>
                    <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em]">Global Music Knowledge Network</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-full border border-white/10 text-[11px] font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all tracking-widest uppercase">
                    Exit Map
                </a>
            </div>
        </div>
    </div>

    {{-- Main Graph Canvas --}}
    <div class="flex-1 relative">
        <livewire:⚡neural-knowledge-graph :isGlobal="true" :height="800" />
        
        {{-- Floating Controls Overlay --}}
        <div class="absolute top-8 right-8 z-30 flex flex-col gap-4">
            <div class="card-premium-unified !bg-[#0d1117]/60 !p-6 backdrop-blur-2xl shadow-3xl border border-white/5">
                <h3 class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] mb-4">Navigation Guide</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <kbd class="px-2 py-1 rounded bg-white/10 text-[9px] text-white/60 border border-white/10 shadow-inner">DRAG</kbd>
                        <span class="text-[10px] font-bold text-white/40">Pan Orbit</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <kbd class="px-2 py-1 rounded bg-white/10 text-[9px] text-white/60 border border-white/10 shadow-inner">SCROLL</kbd>
                        <span class="text-[10px] font-bold text-white/40">Zoom Space</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <kbd class="px-2 py-1 rounded bg-white/10 text-[9px] text-white/60 border border-white/10 shadow-inner">CLICK</kbd>
                        <span class="text-[10px] font-bold text-white/40">Enter Node</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 z-30">
            <div class="px-8 py-4 rounded-full bg-[#0d1117]/60 border border-white/10 backdrop-blur-2xl flex items-center gap-8 shadow-3xl">
                <div class="flex items-center gap-2.5">
                    <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.6)] animate-pulse"></div>
                    <span class="text-[10px] font-black text-white/50 uppercase tracking-widest">Artists</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-3 h-3 rounded-full bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.6)] animate-pulse"></div>
                    <span class="text-[10px] font-black text-white/50 uppercase tracking-widest">Songs</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-3 h-3 rounded-full bg-purple-500 shadow-[0_0_15px_rgba(168,85,247,0.6)] animate-pulse"></div>
                    <span class="text-[10px] font-black text-white/50 uppercase tracking-widest">Genres</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide scrollbars during map exploration */
    body { overflow: hidden !important; }
</style>
@endsection
