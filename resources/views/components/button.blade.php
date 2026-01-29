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
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition-all duration-200 btn-premium';
    
    $variantClasses = match ($variant) {
        'primary' => 'bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-500/25',
        'secondary' => 'bg-white/10 hover:bg-white/20 text-white',
        'outline' => 'bg-transparent border border-white/20 hover:border-white/40 text-white hover:bg-white/5',
        'ghost' => 'bg-transparent hover:bg-white/10 text-gray-400 hover:text-white',
        'danger' => 'bg-red-600 hover:bg-red-500 text-white shadow-lg shadow-red-500/25',
        'success' => 'bg-green-600 hover:bg-green-500 text-white shadow-lg shadow-green-500/25',
        default => 'bg-brand-600 hover:bg-brand-500 text-white',
    };
    
    $sizeClasses = match ($size) {
        'xs' => 'px-3 py-1.5 text-xs',
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
        default => 'px-5 py-2.5 text-sm',
    };
    
    $classes = $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses;
    
    if ($disabled || $loading) {
        $classes .= ' opacity-50 cursor-not-allowed';
    }
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
