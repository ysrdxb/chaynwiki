<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-xl font-black text-[9px] text-white uppercase tracking-[0.2em] hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500/50 transition-all duration-300 shadow-lg shadow-blue-500/10']) }}>
    {{ $slot }}
</button>
