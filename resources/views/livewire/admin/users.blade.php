<div class="space-y-6" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    @section('header', 'Community Nodes')
    @section('subheader', 'Administer user accounts, reputation metrics, and access levels.')

    <!-- Filters -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-96 relative">
            <input type="text" wire:model.live="search" placeholder="Search by name or email..." class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-10 py-3 text-sm focus:border-brand-500/50 focus:ring-0 outline-none transition-all">
            <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <select wire:model.live="filterRole" class="bg-white/[0.03] border border-white/5 rounded-xl px-4 py-3 text-sm outline-none focus:border-brand-500/50 w-full md:w-auto">
            <option value="">All Roles</option>
            <option value="user">User</option>
            <option value="moderator">Moderator</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <!-- Skeleton Loading State -->
    <div x-show="!loaded" class="glass-card overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/[0.02]">
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-20"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-24"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-20"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-14"></div></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @for($i = 0; $i < 5; $i++)
                <tr>
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="skeleton-v2 w-10 h-10 rounded-full mr-4"></div>
                            <div>
                                <div class="skeleton-v2 h-4 w-28 mb-2"></div>
                                <div class="skeleton-v2 h-3 w-36"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-6">
                            <div><div class="skeleton-v2 h-3 w-16 mb-1"></div><div class="skeleton-v2 h-4 w-12"></div></div>
                            <div><div class="skeleton-v2 h-3 w-10 mb-1"></div><div class="skeleton-v2 h-4 w-16"></div></div>
                        </div>
                    </td>
                    <td class="px-8 py-6"><div class="skeleton-v2 h-7 w-20 rounded-lg"></div></td>
                    <td class="px-8 py-6 text-right"><div class="skeleton-v2 h-3 w-16 ml-auto"></div></td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Actual Content -->
    <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
    <!-- Users Table -->
    <div class="glass-card overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/[0.02]">
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Researcher</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Rank & Impact</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Access Level</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500 text-right">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600/20 to-indigo-600/20 flex items-center justify-center font-bold text-brand-400 border border-brand-500/10 mr-4">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold">{{ $user->name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                <div class="mr-6">
                                    <div class="text-[10px] font-bold uppercase text-slate-500">Reputation</div>
                                    <div class="text-sm font-black text-brand-400">{{ number_format($user->reputation_score) }}</div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-slate-500">Rank</div>
                                    <div class="text-sm font-bold">{{ $user->rank_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="bg-white/5 border border-white/5 rounded-lg px-2 py-1 text-[10px] font-bold uppercase outline-none focus:border-brand-500/50">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </td>
                        <td class="px-8 py-6 text-right text-[10px] font-bold text-slate-500">
                            {{ $user->created_at->format('M Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>
    </div><!-- End x-show loaded -->
</div>
