@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/5 border border-white/10 text-white focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm placeholder-gray-500']) }}>
