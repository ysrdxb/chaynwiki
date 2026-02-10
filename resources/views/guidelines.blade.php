@extends('layouts.wiki')

@section('title', 'Contribution Guidelines - ChaynWiki')
@section('meta_description', 'Learn how to create high-quality music wiki entries, citations, and community standards.')

@section('content')
    <section class="pt-28 pb-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-6">Contribution Guidelines</h1>
            <p class="text-white/50 text-sm max-w-2xl leading-relaxed">
                ChaynWiki is a community-run music encyclopedia. Use these guidelines to keep entries accurate, readable, and respectful.
            </p>
        </div>
    </section>

    <section class="py-16 bg-secondary section-divider">
        <div class="max-w-[1200px] mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Accuracy First</h2>
                <p class="text-[#64748b] text-sm">Stick to verifiable facts. Avoid rumors, speculation, or fan fiction.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Citations & Sources</h2>
                <p class="text-[#64748b] text-sm">Link reputable sources for release dates, credits, and chart data.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Neutral Tone</h2>
                <p class="text-[#64748b] text-sm">Write in a balanced, descriptive voice. No promotional language.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Respectful Community</h2>
                <p class="text-[#64748b] text-sm">Be constructive. Use revision notes to explain changes.</p>
            </div>
        </div>
    </section>
@endsection
