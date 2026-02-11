<div wire:poll.10s="refreshStatus">
    @if($isConnected && $track)
        <div class="relative group overflow-hidden bg-black/40 backdrop-blur-xl border border-white/5 rounded-3xl p-6 transition-all hover:bg-black/60">
            <div class="absolute -inset-1 bg-gradient-to-br from-[#38bdf8]/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <div class="flex items-center gap-6 relative z-10">
                <!-- Album Art -->
                <div class="relative shrink-0 group/art">
                    @if($track['image'])
                        <img src="{{ $track['image'] }}" class="w-16 h-16 rounded-xl shadow-2xl transition-transform group-hover/art:scale-110">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 bg-[#1DB954] p-1 rounded-full shadow-lg">
                        <svg class="w-3 h-3 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.491 17.306c-.215.353-.671.465-1.023.249-2.813-1.718-6.353-2.107-10.518-1.157-.404.092-.814-.158-.906-.563-.092-.404.158-.813.563-.906 4.565-1.044 8.468-.598 11.635 1.336.352.215.464.671.249 1.021zm1.468-3.259c-.27.439-.844.581-1.282.311-3.218-1.977-8.123-2.553-11.93-1.4c-.493.15-1.018-.13-1.168-.623-.15-.493.13-1.018.623-1.168 4.356-1.321 9.771-.659 13.446 1.599.438.27.581.844.311 1.281zm.142-3.39c-3.858-2.291-10.219-2.502-13.882-1.391-.59.179-1.21-.168-1.389-.758-.179-.59.168-1.21.758-1.389 4.218-1.28 11.238-1.037 15.632 1.571.531.315.704 1.003.389 1.534-.315.531-1.003.704-1.534.389z"/></svg>
                    </div>
                </div>

                <!-- Text Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-black text-[#38bdf8] uppercase tracking-[0.2em] animate-pulse">Now Playing</span>
                    </div>
                    @if(isset($track['url']))
                        <a href="{{ $track['url'] }}" target="_blank" class="block text-lg font-black text-white hover:text-[#38bdf8] transition-colors truncate tracking-tighter uppercase leading-none mb-1">
                            {{ $track['title'] }}
                        </a>
                    @else
                        <span class="block text-lg font-black text-white truncate tracking-tighter uppercase leading-none mb-1">
                            {{ $track['title'] }}
                        </span>
                    @endif
                    <p class="text-xs font-medium text-white/50 truncate tracking-tight">
                        {{ $track['artist'] }} — {{ $track['album'] }}
                    </p>
                </div>

                <!-- Visualizer bars -->
                @if($track['is_playing'])
                <div class="flex items-end gap-[3px] h-6 mb-1 opacity-60">
                    <div class="w-1 bg-[#38bdf8] animate-visualizer-1 rounded-full"></div>
                    <div class="w-1 bg-[#38bdf8] animate-visualizer-2 rounded-full"></div>
                    <div class="w-1 bg-[#38bdf8] animate-visualizer-3 rounded-full"></div>
                    <div class="w-1 bg-[#38bdf8] animate-visualizer-2 rounded-full"></div>
                </div>
                @endif
            </div>
        </div>
    @elseif($isConnected && !$track)
         <div class="bg-black/20 border border-white/5 rounded-3xl p-6">
            <div class="flex items-center gap-4 opacity-40">
                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Spotify Connected</span>
                    <p class="text-xs font-medium text-white/20">Not currently listening</p>
                </div>
            </div>
         </div>
    @elseif(optional(auth()->user())->id == $user->id)
        <a href="{{ route('auth.spotify.redirect') }}" class="flex items-center justify-between bg-[#1DB954]/10 border border-[#1DB954]/20 rounded-3xl p-6 group hover:bg-[#1DB954]/20 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#1DB954]/20 flex items-center justify-center">
                     <svg class="w-6 h-6 text-[#1DB954]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.491 17.306c-.215.353-.671.465-1.023.249-2.813-1.718-6.353-2.107-10.518-1.157-.404.092-.814-.158-.906-.563-.092-.404.158-.813.563-.906 4.565-1.044 8.468-.598 11.635 1.336.352.215.464.671.249 1.021zm1.468-3.259c-.27.439-.844.581-1.282.311-3.218-1.977-8.123-2.553-11.93-1.4c-.493.15-1.018-.13-1.168-.623-.15-.493.13-1.018.623-1.168 4.356-1.321 9.771-.659 13.446 1.599.438.27.581.844.311 1.281zm.142-3.39c-3.858-2.291-10.219-2.502-13.882-1.391-.59.179-1.21-.168-1.389-.758-.179-.59.168-1.21.758-1.389 4.218-1.28 11.238-1.037 15.632 1.571.531.315.704 1.003.389 1.534-.315.531-1.003.704-1.534.389z"/></svg>
                </div>
                <div>
                    <span class="text-xs font-black text-white uppercase tracking-widest">Connect Spotify</span>
                    <p class="text-[10px] font-medium text-white/40">Broadcasting status live to profile</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-white/20 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    @endif
</div>
