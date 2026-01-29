@props([
    'text' => '',
    'position' => 'top',
])

@php
    $positionClasses = match ($position) {
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        default => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
    };
    
    $arrowClasses = match ($position) {
        'top' => 'top-full left-1/2 -translate-x-1/2 border-t-gray-800',
        'bottom' => 'bottom-full left-1/2 -translate-x-1/2 border-b-gray-800',
        'left' => 'left-full top-1/2 -translate-y-1/2 border-l-gray-800',
        'right' => 'right-full top-1/2 -translate-y-1/2 border-r-gray-800',
        default => 'top-full left-1/2 -translate-x-1/2 border-t-gray-800',
    };
@endphp

<div 
    x-data="{ show: false }"
    @mouseenter="show = true"
    @mouseleave="show = false"
    @focus="show = true"
    @blur="show = false"
    class="relative inline-block"
>
    {{-- Trigger --}}
    <div>
        {{ $slot }}
    </div>

    {{-- Tooltip --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 {{ $positionClasses }}"
        style="display: none;"
    >
        <div class="px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-lg shadow-lg whitespace-nowrap">
            {{ $text }}
        </div>
        {{-- Arrow --}}
        <div class="absolute w-0 h-0 border-4 border-transparent {{ $arrowClasses }}"></div>
    </div>
</div>
