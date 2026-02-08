@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'loading' => false,
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-extrabold rounded-full transition-all duration-300';
    
    $variantClasses = match ($variant) {
        'primary' => 'bg-white text-[#0d1117] hover:bg-gray-100 hover:scale-[1.02] shadow-xl',
        'secondary' => 'bg-transparent border border-white/10 text-white hover:border-[#3b82f6] hover:bg-[#3b82f6]/5',
        'outline' => 'bg-transparent border border-white/20 hover:border-white/40 text-white',
        'ghost' => 'bg-transparent hover:bg-white/5 text-white/50 hover:text-white',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white',
        default => 'bg-white text-[#0d1117]',
    };
    
    $sizeClasses = match ($size) {
        'xs' => 'px-4 py-1.5 text-xs',
        'sm' => 'px-5 py-2 text-sm',
        'md' => 'px-6 py-2.5 text-sm',
        'lg' => 'px-8 py-3.5 text-base',
        'xl' => 'px-10 py-4.5 text-lg',
        default => 'px-6 py-2.5 text-sm',
    };
    
    $classes = $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses;
@endphp

@if($href && !$disabled)
    <a 
        href="{{ $href }}" 
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if($icon && !$loading)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </a>
@else
    <button 
        type="{{ $type }}"
        @if($disabled || $loading) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </button>
@endif
