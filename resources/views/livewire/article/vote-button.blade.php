<div class="flex items-center bg-white/[0.03] border border-white/5 rounded-full p-1 gap-1" 
    x-data="{ 
        score: {{ $score }}, 
        userVote: {{ $userVote }},
        vote(val) {
            if (this.userVote === val) {
                this.score -= val;
                this.userVote = 0;
            } else {
                this.score = this.score - this.userVote + val;
                this.userVote = val;
            }
            $wire.vote(val);
        }
    }">
    {{-- Upvote --}}
    <button @click="vote(1)" 
        class="relative group p-2 rounded-full transition-all duration-300"
        :class="userVote === 1 ? 'text-blue-500 bg-blue-500/10' : 'text-white/40 hover:text-white hover:bg-white/5'">
        <div class="relative z-10 transition-transform group-active:scale-125">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
            </svg>
        </div>
        <template x-if="userVote === 1">
            <div class="absolute inset-0 bg-blue-500/20 blur-md rounded-full animate-pulse"></div>
        </template>
    </button>

    {{-- Score --}}
    <div class="px-2 min-w-[2rem] text-center">
        <span class="text-[11px] font-black tracking-tighter transition-colors"
            :class="userVote !== 0 ? 'text-white' : 'text-white/60'"
            x-text="(score > 0 ? '+' : '') + score">
        </span>
    </div>

    {{-- Downvote --}}
    <button @click="vote(-1)" 
        class="relative group p-2 rounded-full transition-all duration-300"
        :class="userVote === -1 ? 'text-red-500 bg-red-500/10' : 'text-white/40 hover:text-red-400/60 hover:bg-red-500/5'">
        <div class="relative z-10 transition-transform group-active:scale-125">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <template x-if="userVote === -1">
            <div class="absolute inset-0 bg-red-500/20 blur-md rounded-full animate-pulse"></div>
        </template>
    </button>
</div>
