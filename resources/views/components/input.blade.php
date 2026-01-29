@props([
    'label' => null,
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'icon' => null,
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-300">
            {{ $label }}
            @if($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                {!! $icon !!}
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            {{ $attributes->except(['class', 'wire:model', 'wire:model.live'])->merge([
                'class' => 'w-full px-4 py-3 rounded-xl bg-[#0A0A14] border text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all ' .
                    ($icon ? 'pl-10 ' : '') .
                    ($error ? 'border-red-500/50 focus:border-red-500' : 'border-white/10 focus:border-brand-500') .
                    ($disabled ? ' opacity-50 cursor-not-allowed' : '')
            ]) }}
            {{ $attributes->only(['wire:model', 'wire:model.live']) }}
        >
    </div>

    @if($error)
        <p class="text-red-400 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $error }}
        </p>
    @elseif($hint)
        <p class="text-gray-500 text-sm">{{ $hint }}</p>
    @endif
</div>
