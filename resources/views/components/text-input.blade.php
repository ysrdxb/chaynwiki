@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-primary/50 border border-white/5 text-white focus:border-blue-500/30 focus:ring-blue-500/10 rounded-xl px-4 py-2.5 text-sm transition-all placeholder-white/10 shadow-inner']) }}>
