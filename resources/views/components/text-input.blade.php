@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-primary/50 border border-white/5 text-white focus:border-[#38bdf8]/30 focus:ring-[#38bdf8]/10 rounded-xl px-4 py-2.5 text-sm transition-all placeholder-white/10 shadow-inner']) }}>
