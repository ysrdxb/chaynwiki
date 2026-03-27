@extends('layouts.wiki')

@section('title', 'Legal - ChaynWiki')

@section('content')
    <section class="pt-28 pb-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter mb-6">Legal</h1>
            <p class="text-white/50 text-sm max-w-2xl leading-relaxed">
                ChaynWiki content is community-contributed. Users are responsible for the accuracy and rights of their submissions.
            </p>
        </div>
    </section>

    <section class="py-16 bg-secondary section-divider">
        <div class="max-w-[1200px] mx-auto px-8 space-y-6">
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Content Rights</h2>
                <p class="text-[#64748b] text-sm">Do not submit copyrighted material without permission.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Attribution</h2>
                <p class="text-[#64748b] text-sm">Edits are attributed to contributors for transparency.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Moderation</h2>
                <p class="text-[#64748b] text-sm">We reserve the right to remove content that violates policies.</p>
            </div>
        </div>
    </section>
@endsection
