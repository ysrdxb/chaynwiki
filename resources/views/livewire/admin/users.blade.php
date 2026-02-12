<div class="space-y-8">
    
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            @section('header', 'Community')
            @section('subheader', 'Manage user accounts, roles, and reputation.')
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
             <div class="relative group">
                <input type="text" wire:model.live="search" placeholder="Search users..." class="pl-10 pr-4 py-2.5 bg-[#161b22]/60 border border-white/10 rounded-xl text-sm text-white placeholder-white/20 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all w-64 group-hover:w-80 group-focus-within:w-80">
                <svg class="w-4 h-4 text-white/40 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <select wire:model.live="filterRole" class="px-4 py-2.5 bg-[#161b22]/60 border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all appearance-none cursor-pointer hover:bg-white/5">
                <option value="">All Roles</option>
                <option value="user">Researcher</option>
                <option value="moderator">Moderator</option>
                <option value="admin">Administrator</option>
            </select>
        </div>
    </div>

    <!-- Actual Content -->
    <div>
        <div class="bg-[#161b22]/60 backdrop-blur-xl border border-white/5 rounded-[24px] overflow-hidden shadow-2xl relative">
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 px-8 py-5 border-b border-white/5 bg-white/[0.02]">
                <div class="col-span-4 text-[10px] font-black text-white/40 uppercase tracking-widest">User Profile</div>
                <div class="col-span-3 text-[10px] font-black text-white/40 uppercase tracking-widest">Rank & Impact</div>
                <div class="col-span-3 text-[10px] font-black text-white/40 uppercase tracking-widest">Access Level</div>
                <div class="col-span-2 text-[10px] font-black text-white/40 uppercase tracking-widest text-right">Joined</div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-white/5">
                @foreach($users as $user)
                    <div class="grid grid-cols-12 gap-4 px-8 py-4 items-center hover:bg-white/[0.02] transition-colors group">
                        
                        <!-- User Profile -->
                        <div class="col-span-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-600/20 to-blue-600/20 flex items-center justify-center font-bold text-white border border-white/10 shadow-lg relative">
                                {{ substr($user->name, 0, 1) }}
                                @if($user->is_online ?? false)
                                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#161b22] rounded-full"></span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-[14px] font-bold text-white group-hover:text-purple-400 transition-colors truncate">{{ $user->name }}</div>
                                <div class="text-[10px] text-white/40 font-mono mt-0.5 truncate">{{ $user->email }}</div>
                            </div>
                        </div>

                        <!-- Rank & Impact -->
                        <div class="col-span-3">
                            <div class="flex items-center gap-4">
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-white/30">Reputation</div>
                                    <div class="text-[13px] font-black text-white">{{ number_format($user->reputation_score) }}</div>
                                </div>
                                <div class="h-6 w-px bg-white/10"></div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-white/30">Rank</div>
                                    <div class="text-[11px] font-bold text-purple-400">{{ $user->rank_name ?? 'Novice' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Access Level -->
                        <div class="col-span-3">
                            <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="bg-black/20 border border-white/10 rounded-lg px-3 py-1.5 text-[11px] font-bold uppercase text-white outline-none focus:border-purple-500/50 hover:bg-white/5 transition-colors cursor-pointer">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Researcher</option>
                                <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>

                        <!-- Joined -->
                        <div class="col-span-2 text-right text-[11px] font-bold text-white/30">
                            {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer / Pagination -->
            <div class="px-8 py-4 border-t border-white/5 bg-white/[0.02]">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
