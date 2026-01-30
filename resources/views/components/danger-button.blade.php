<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-red-600/10 border border-red-600/20 rounded-xl font-black text-[9px] text-red-500 uppercase tracking-[0.2em] hover:bg-red-600 hover:text-white focus:outline-none focus:ring-1 focus:ring-red-500/50 transition-all duration-300 shadow-lg shadow-red-500/5']) }}>
    {{ $slot }}
</button>
