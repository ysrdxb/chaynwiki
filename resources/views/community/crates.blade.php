@extends('layouts.wiki')

@section('title', 'Community Crates - ChaynWiki')

@section('content')
<div class="min-h-screen bg-[#0d1117] pt-32 pb-24">
    <div class="max-w-[1400px] mx-auto px-8">
        <!-- Breadcrumbs Area -->
        <div class="flex items-center gap-4 mb-12">
            <a href="{{ route('home') }}" class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] hover:text-blue-500 transition-colors">Home</a>
            <div class="w-1 h-1 rounded-full bg-white/10"></div>
            <span class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em]">Community Crates</span>
        </div>

        <!-- Main Content -->
        <livewire:explore.crate-explore />
    </div>
</div>
@endsection
