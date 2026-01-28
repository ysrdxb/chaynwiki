<div>
    <button 
        wire:click="toggle" 
        class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-300 {{ $isBookmarked ? 'bg-brand-500/20 text-brand-400 border border-brand-500/30' : 'bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10' }}"
    >
        <svg class="w-5 h-5 {{ $isBookmarked ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
        </svg>
        <span class="text-xs font-bold uppercase tracking-widest">
            {{ $isBookmarked ? 'Saved' : 'Save Record' }}
        </span>
    </button>
</div>
