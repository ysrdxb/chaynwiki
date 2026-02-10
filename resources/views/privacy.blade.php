@extends('layouts.wiki')

@section('title', 'Privacy - ChaynWiki')

@section('content')
    <section class="pt-28 pb-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-6">Privacy</h1>
            <p class="text-white/50 text-sm max-w-2xl leading-relaxed">
                We collect minimal data required to operate the archive. Account activity and edits are logged for audit and transparency.
            </p>
        </div>
    </section>

    <section class="py-16 bg-secondary section-divider">
        <div class="max-w-[1200px] mx-auto px-8 space-y-6">
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">What We Store</h2>
                <p class="text-[#64748b] text-sm">Account details, content edits, and engagement metrics needed for the public ledger.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">How We Use Data</h2>
                <p class="text-[#64748b] text-sm">Data is used for authentication, moderation, and maintaining record integrity.</p>
            </div>
            <div class="bg-[#0f1419] border border-white/5 rounded-2xl p-6">
                <h2 class="text-white font-black uppercase tracking-widest text-sm mb-3">Your Control</h2>
                <p class="text-[#64748b] text-sm">You can update profile data and request account removal via settings.</p>
            </div>
        </div>
    </section>
@endsection
