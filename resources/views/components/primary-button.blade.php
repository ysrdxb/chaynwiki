<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-[#38bdf8] border border-transparent rounded-xl font-black text-[9px] text-[#0a0e14] uppercase tracking-[0.2em] hover:bg-[#7dd3fc] focus:bg-[#7dd3fc] active:bg-[#0ea5e9] focus:outline-none focus:ring-1 focus:ring-[#38bdf8]/50 transition-all duration-300 shadow-lg shadow-[#38bdf8]/10']) }}>
    {{ $slot }}
</button>
