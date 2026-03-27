<div>
    <button 
        wire:click="toggle" 
        class="{{ $isBookmarked ? 'btn-figma-primary !bg-blue-500 !text-white' : 'btn-figma-secondary' }} !w-full !py-4 flex items-center justify-center gap-3"
    >
        <div class="figma-icon {{ $isBookmarked ? '!bg-white !text-blue-500' : '' }}">
            <svg class="w-3 h-3 text-current" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
            </svg>
        </div>
        <span class="text-xs font-bold tracking-widest uppercase">
            {{ $isBookmarked ? 'Saved' : 'Bookmark' }}
        </span>
    </button>
</div>
