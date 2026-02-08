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

<div {{ $attributes->only('class')->merge(['class' => 'space-y-3']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-[14px] font-bold text-white/50 uppercase tracking-widest" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $label }}
            @if($required)
                <span class="text-blue-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative group">
        @if($icon)
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-blue-500 transition-colors">
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
                'class' => 'w-full px-5 py-3.5 rounded-2xl bg-[#161b22]/50 border border-white/5 text-white placeholder-white/20 focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 ' .
                    ($icon ? 'pl-12 ' : '') .
                    ($error ? 'border-red-500/50 focus:border-red-500' : '') .
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
