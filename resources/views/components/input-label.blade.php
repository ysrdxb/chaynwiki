@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-[9px] text-white/10 uppercase tracking-widest']) }}>
    {{ $value ?? $slot }}
</label>
