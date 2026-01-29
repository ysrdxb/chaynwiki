<div class="mt-12">
<div class="mt-12">

    <!-- Auth Check -->
    @auth
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-10">
            <div class="flex items-start gap-4">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <form wire:submit="submit">
                        <textarea wire:model="content" rows="3" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition resize-none" placeholder="Add to the discussion..."></textarea>
                        @error('content') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        
                        <div class="flex justify-end mt-2">
                            <button type="submit" class="px-6 py-2 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-full transition">
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 text-center text-gray-400 mb-10">
            Please <a href="{{ route('login') }}" class="text-brand-400 hover:underline">log in</a> to join the discussion.
        </div>
    @endauth

    <!-- Comments List -->
    <div class="space-y-8">
        @forelse($comments as $comment)
            <div class="group relative animate-fade-in-up">
                <div class="flex gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}&background=random" class="w-10 h-10 rounded-full ring-2 ring-gray-800">
                    
                    <div class="flex-1">
                        <!-- Header -->
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-white">{{ $comment->user->name }}</span>
                            <span class="text-xs text-brand-400 bg-brand-400/10 px-2 py-0.5 rounded-full">Contributor</span>
                            <span class="text-xs text-gray-600">• {{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Content -->
                        <div class="text-gray-300 leading-relaxed mb-3">
                            {{ $comment->content }}
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 text-xs font-medium text-gray-500">
                             <livewire:article.vote-button :model="$comment" wire:key="vote-comment-{{ $comment->id }}" />
                            
                            @auth
                                <button wire:click="setReply({{ $comment->id }})" class="hover:text-white transition">Reply</button>
                                @if($comment->user_id === auth()->id())
                                    <button wire:click="delete({{ $comment->id }})" class="text-red-500/50 hover:text-red-400 transition">Delete</button>
                                @endif
                            @endauth
                        </div>

                        <!-- Reply Form -->
                        @if($showReplyForm === $comment->id)
                            <div class="mt-4 pl-4 border-l-2 border-brand-500/30">
                                <form wire:submit="submit">
                                    <textarea wire:model="content" rows="2" class="w-full bg-black/20 border border-white/10 rounded-lg px-3 py-2 text-white text-sm focus:ring-1 focus:ring-brand-500 focus:border-transparent transition resize-none" placeholder="Write a reply..."></textarea>
                                    <div class="flex gap-2 mt-2">
                                        <button type="submit" class="px-4 py-1.5 bg-brand-600 text-white text-xs font-bold rounded-lg hover:bg-brand-500 transition">Reply</button>
                                        <button type="button" wire:click="cancelReply" class="px-4 py-1.5 bg-white/5 text-gray-400 text-xs font-bold rounded-lg hover:bg-white/10 transition">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- Replies -->
                        @if($comment->replies->count() > 0)
                            <div class="mt-6 space-y-6">
                                @foreach($comment->replies as $reply)
                                    <div class="flex gap-3 pl-4 border-l-2 border-white/5">
                                        <img src="https://ui-avatars.com/api/?name={{ $reply->user->name }}&background=random" class="w-8 h-8 rounded-full ring-2 ring-gray-800">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-bold text-sm text-white">{{ $reply->user->name }}</span>
                                                <span class="text-xs text-gray-600">• {{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-400">{{ $reply->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-500 text-center py-8">
                No comments yet. Be the first to start the conversation!
            </div>
        @endforelse
    </div>
</div>
