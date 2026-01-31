<div class="mt-16 space-y-12">
    <!-- Section Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
        <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-500">Protocol Discussion</h3>
        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
    </div>

    <!-- Auth Check / Comment Form -->
    @auth
    <div class="bg-white/[0.02] border border-white/5 rounded-3xl p-8 backdrop-blur-md">
        <div class="flex gap-6">
            <div class="relative shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D0D1A&color=fff" class="w-12 h-12 rounded-2xl border border-white/10">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-blue-500 border-2 border-[#050510]"></div>
            </div>
            <div class="flex-1">
                <form wire:submit="submit" class="space-y-4">
                    <div class="relative group">
                        <textarea wire:model="content" rows="3" 
                            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white placeholder:text-white/10 focus:border-blue-500/50 transition-all outline-none resize-none" 
                            placeholder="Initialize contribution to the thread..."></textarea>
                        <div class="absolute bottom-4 right-4 text-[8px] font-black text-slate-500 tracking-widest uppercase pointer-events-none">Signal Ready</div>
                    </div>
                    @error('content') <span class="text-red-500/80 text-[10px] font-bold uppercase tracking-wider">{{ $message }}</span> @enderror
                    
                    <div class="flex justify-between items-center">
                        <div class="text-[9px] text-slate-500 font-medium italic">Your contribution will be archived in the permanent record.</div>
                        <button type="submit" class="group relative px-6 py-2.5 bg-white text-black rounded-lg font-black text-[10px] uppercase tracking-widest overflow-hidden hover:scale-105 transition-transform active:scale-95">
                            <span class="relative z-10">Broadcast Comment</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white/[0.02] border border-white/5 rounded-3xl p-12 text-center backdrop-blur-md border-dashed">
        <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-5 h-5 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <p class="text-xs text-slate-400 mb-6 font-medium">Authentication required to participate in the knowledge stream.</p>
        <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-white text-black rounded-full text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all">Identify System</a>
    </div>
    @endauth

    <!-- Comments Stream -->
    <div class="space-y-12">
        @forelse($comments as $comment)
        <div class="group/comment relative" x-data="{ replying: false }">
            <div class="flex gap-6">
                <!-- Avatar and Thread Line -->
                <div class="flex flex-col items-center shrink-0">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}&background=0D0D1A&color=fff" class="w-10 h-10 rounded-xl border border-white/5 group-hover/comment:border-white/20 transition-colors">
                        @if($comment->user->reputation_score > 500)
                        <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center border-2 border-[#050510]">
                            <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.25.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                        </div>
                        @endif
                    </div>
                    @if(!$loop->last || $comment->replies->count() > 0)
                    <div class="mt-4 w-px flex-1 bg-gradient-to-b from-white/10 to-transparent"></div>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <!-- User Info & Meta -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-black text-white uppercase tracking-wider">{{ $comment->user->name }}</span>
                            @if($comment->user->rank_name !== 'Novice')
                                <span class="px-2 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-[7px] font-black text-blue-400 uppercase tracking-[0.2em]">
                                    {{ $comment->user->rank_name }}
                                </span>
                            @endif
                            <span class="w-1 h-1 rounded-full bg-white/10"></span>
                            <span class="text-[9px] font-medium text-slate-500 uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="opacity-0 group-hover/comment:opacity-100 transition-opacity">
                             <livewire:article.vote-button :model="$comment" wire:key="vote-comment-{{ $comment->id }}" />
                        </div>
                    </div>

                    <!-- Comment Content -->
                    <div class="relative bg-white/[0.02] border border-white/5 rounded-2xl p-5 hover:bg-white/[0.03] transition-colors">
                        <p class="text-[13px] text-white/70 leading-relaxed">{{ $comment->content }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-6 mt-4">
                        <button wire:click="setReply({{ $comment->id }})" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-500 transition-colors">Echo Response</button>
                        @if($comment->user_id === auth()->id())
                        <button wire:click="delete({{ $comment->id }})" class="text-[10px] font-black uppercase tracking-widest text-red-500/50 hover:text-red-500 transition-colors">Decommission</button>
                        @endif
                    </div>

                    <!-- Local Reply Form -->
                    @if($showReplyForm === $comment->id)
                    <div class="mt-6 ml-4 p-6 bg-blue-500/5 border border-blue-500/10 rounded-2xl animate-fade-in">
                        <form wire:submit="submit" class="space-y-4">
                            <textarea wire:model="content" rows="2" 
                                class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder:text-white/10 focus:border-blue-500/50 outline-none resize-none" 
                                placeholder="Entering sub-stream data..."></textarea>
                            <div class="flex gap-3">
                                <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded-lg text-[10px] font-black uppercase tracking-widest">Connect</button>
                                <button type="button" wire:click="cancelReply" class="px-5 py-2 bg-white/5 text-white/20 rounded-lg text-[10px] font-black uppercase tracking-widest hover:text-white transition-colors">Abort</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Nested Replies -->
                    @if($comment->replies->count() > 0)
                    <div class="mt-8 space-y-6 ml-4 pl-6 border-l border-white/5">
                        @foreach($comment->replies as $reply)
                        <div class="relative group/reply">
                            <div class="flex gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ $reply->user->name }}&background=0D0D1A&color=fff" class="w-8 h-8 rounded-lg border border-white/5">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[10px] font-black text-white/60 uppercase">{{ $reply->user->name }}</span>
                                        <span class="text-[8px] text-white/10 uppercase tracking-widest">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="bg-white/[0.01] border border-white/5 rounded-xl p-3">
                                        <p class="text-xs text-white/40 leading-relaxed">{{ $reply->content }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center text-slate-600">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <p class="text-xs font-black uppercase tracking-[0.2em]">Archive Empty – Seeking First Entry</p>
        </div>
        @endforelse
    </div>
</div>
