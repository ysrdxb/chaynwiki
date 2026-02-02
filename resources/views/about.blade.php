@extends('layouts.wiki')

@section('title', 'About - ChaynWiki')

@section('content')
    <section class="pt-28 pb-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter mb-6">About ChaynWiki</h1>
            <p class="text-white/50 text-sm max-w-2xl leading-relaxed">
                ChaynWiki is a community-driven music encyclopedia focused on verifiable records, collaborative editing, and transparent attribution.
            </p>
        </div>
    </section>

    <section class="py-16 bg-secondary section-divider">
        <div class="max-w-[1200px] mx-auto px-8 grid md:grid-cols-3 gap-8">
            <div class="bg-[#0D0D1A] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Open Archive</h2>
                <p class="text-white/50 text-sm">Every record is editable, traceable, and backed by contributor history.</p>
            </div>
            <div class="bg-[#0D0D1A] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Transparent Metrics</h2>
                <p class="text-white/50 text-sm">Views, edits, and contributions are displayed to maintain clarity.</p>
            </div>
            <div class="bg-[#0D0D1A] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Community First</h2>
                <p class="text-white/50 text-sm">Built for listeners, creators, and researchers with shared ownership.</p>
            </div>
        </div>
    </section>
@endsection
