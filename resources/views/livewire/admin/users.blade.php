<div class="space-y-10">
    
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-600/10 border border-purple-500/20 flex items-center justify-center text-purple-500 shadow-xl shadow-purple-500/5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <h2 class="text-[28px] font-black text-white uppercase tracking-tighter leading-none">Community Management</h2>
                <p class="text-white/40 text-[12px] font-bold uppercase tracking-widest mt-1.5">Manage accounts, roles & reputation scores</p>
            </div>
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
             <div class="relative group">
                <input type="text" wire:model.live="search" placeholder="Search identities..." class="pl-12 pr-6 py-3.5 bg-[#161b22] border border-white/10 rounded-[18px] text-[13px] font-bold text-white placeholder-white/20 focus:outline-none focus:border-purple-500/50 focus:ring-0 transition-all w-64 group-hover:w-80 group-focus-within:w-80 shadow-2xl">
                <svg class="w-4 h-4 text-white/20 absolute left-4 top-1/2 -translate-y-1/2 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <div class="relative">
                <select wire:model.live="filterRole" class="pl-6 pr-10 py-3.5 bg-[#161b22] border border-white/10 rounded-[18px] text-[11px] font-black uppercase tracking-widest text-white/60 focus:outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer hover:bg-white/5 hover:text-white shadow-2xl">
                    <option value="">All Clearances</option>
                    <option value="user">Researcher</option>
                    <option value="moderator">Moderator</option>
                    <option value="admin">Administrator</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-40">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Actual Content -->
    <div class="bg-[#161b22] border border-white/5 rounded-[32px] overflow-hidden shadow-2xl relative">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Identity Profile</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Social Graph Metric</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Authorization Level</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] text-right">Inception Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @foreach($users as $user)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <!-- User Profile -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-purple-600/20 to-blue-600/20 flex items-center justify-center font-black text-white border border-white/10 shadow-xl relative group-hover:scale-105 transition-transform duration-500">
                                        {{ substr($user->name, 0, 1) }}
                                        @if($user->is_online ?? false)
                                            <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-[3px] border-[#161b22] rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[15px] font-black text-white group-hover:text-purple-400 transition-colors truncate tracking-tight">{{ $user->name }}</div>
                                        <div class="text-[11px] text-white/30 font-bold mt-1 uppercase tracking-widest truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Rank & Impact -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-6">
                                    <div>
                                        <div class="text-[9px] font-black uppercase text-white/20 tracking-[0.2em] mb-1">Reputation</div>
                                        <div class="text-[14px] font-black text-white tracking-tighter">{{ number_format($user->reputation_score) }}</div>
                                    </div>
                                    <div class="h-8 w-px bg-white/5"></div>
                                    <div>
                                        <div class="text-[9px] font-black uppercase text-white/20 tracking-[0.2em] mb-1">Status</div>
                                        <div class="text-[11px] font-black text-purple-400 uppercase tracking-widest">{{ $user->rank_name ?? 'Novice' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Access Level -->
                            <td class="px-10 py-5">
                                <div class="relative inline-block w-48">
                                    <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-2.5 text-[11px] font-black uppercase tracking-widest text-white/60 outline-none focus:border-purple-500/50 hover:bg-white/10 hover:text-white transition-all cursor-pointer appearance-none">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Researcher</option>
                                        <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-40">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </td>

                            <!-- Joined -->
                            <td class="px-10 py-5 text-right">
                                <div class="text-[12px] font-black text-white/40 uppercase tracking-widest">
                                    {{ $user->created_at->format('M Y') }}
                                </div>
                                <div class="text-[9px] text-white/20 font-bold uppercase mt-1">Acquired</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        <div class="px-10 py-6 border-t border-white/5 bg-white/[0.02]">
            {{ $users->links() }}
        </div>
    </div>
</div>

