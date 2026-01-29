@props([
    'href' => null,
    'gradient' => false,
    'tilt' => false,
])

@php
    $tag = $href ? 'a' : 'div';
    $classes = 'block relative group bg-[#0A0A14] border border-white/10 rounded-2xl overflow-hidden transition-all duration-300';
    
    if ($gradient) {
        $classes .= ' card-gradient-border';
    } else {
        $classes .= ' card-premium';
    }
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($tilt) data-tilt @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{-- Hover gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    
    {{-- Content --}}
    <div class="relative z-10">
        {{ $slot }}
    </div>

    {{-- Bottom glow on hover --}}
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3/4 h-1 bg-gradient-to-r from-transparent via-brand-500/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
</{{ $tag }}>
