<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-2.5 bg-white/5 border border-white/5 rounded-xl font-black text-[9px] text-white uppercase tracking-[0.2em] hover:bg-white/10 focus:outline-none focus:ring-1 focus:ring-white/10 transition-all duration-300 shadow-sm disabled:opacity-25']) }}>
    {{ $slot }}
</button>
