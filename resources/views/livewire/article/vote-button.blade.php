<div class="flex items-center gap-1">
    {{-- Upvote --}}
    <button wire:click="vote(1)" class="group flex items-center transition {{ $userVote === 1 ? 'text-brand-400' : 'text-gray-500 hover:text-gray-300' }}">
        <div class="p-1 rounded-full {{ $userVote === 1 ? 'bg-brand-400/10' : 'group-hover:bg-white/5' }}">
            <svg class="w-5 h-5" fill="{{ $userVote === 1 ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
        </div>
    </button>

    {{-- Score --}}
    <span class="font-bold text-sm min-w-[1.5rem] text-center {{ $userVote !== 0 ? 'text-brand-400' : 'text-gray-400' }}">
        {{ $score }}
    </span>

    {{-- Downvote --}}
    <button wire:click="vote(-1)" class="group flex items-center transition {{ $userVote === -1 ? 'text-red-400' : 'text-gray-500 hover:text-gray-300' }}">
        <div class="p-1 rounded-full {{ $userVote === -1 ? 'bg-red-400/10' : 'group-hover:bg-white/5' }}">
            <svg class="w-5 h-5" fill="{{ $userVote === -1 ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
    </button>
</div>
