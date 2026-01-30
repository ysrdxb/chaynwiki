<div class="space-y-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    <!-- Skeleton Loading State -->
    <div x-show="!loaded" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i = 0; $i < 4; $i++)
            <div class="glass-card p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="skeleton-v2 h-3 w-20 mb-2"></div>
                        <div class="skeleton-v2 h-9 w-24 mt-1"></div>
                    </div>
                    <div class="skeleton-v2 w-12 h-12 rounded-xl"></div>
                </div>
                <div class="skeleton-v2 h-3 w-20 mt-6"></div>
            </div>
            @endfor
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 glass-card p-6">
                <div class="skeleton-v2 h-6 w-40 mb-6"></div>
                <div class="skeleton-v2 h-64 w-full rounded-xl"></div>
            </div>
            <div class="glass-card p-6">
                <div class="skeleton-v2 h-6 w-36 mb-6"></div>
                <div class="space-y-4">
                    @for($i = 0; $i < 5; $i++)
                    <div class="flex items-center gap-4">
                        <div class="skeleton-v2 w-10 h-10 rounded-full"></div>
                        <div class="flex-1">
                            <div class="skeleton-v2 h-4 w-32 mb-2"></div>
                            <div class="skeleton-v2 h-3 w-20"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Actual Content -->
    <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-8" style="display: none;">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Total Nodes</p>
                    <h3 class="text-3xl font-display font-black mt-1">{{ number_format($stats['articles']) }}</h3>
                </div>
                <div class="p-3 bg-blue-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] font-bold text-emerald-500 lg:mt-6">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                4.2% Growth
            </div>
        </div>

        <div class="glass-card p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Researchers</p>
                    <h3 class="text-3xl font-display font-black mt-1">{{ number_format($stats['users']) }}</h3>
                </div>
                <div class="p-3 bg-indigo-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] font-bold text-emerald-500 lg:mt-6">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                12 New this week
            </div>
        </div>

        <div class="glass-card p-6 border-blue-500/20">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Global Impact</p>
                    <h3 class="text-3xl font-display font-black mt-1">{{ number_format($stats['total_reputation']) }}</h3>
                </div>
                <div class="p-3 bg-blue-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] font-bold text-emerald-500 lg:mt-6">
                Active Energy Surge
            </div>
        </div>

        <div class="glass-card p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Moderation Queue</p>
                    <h3 class="text-3xl font-display font-black mt-1 {{ $stats['pending_revisions'] > 0 ? 'text-amber-500' : '' }}">
                        {{ $stats['pending_revisions'] }}
                    </h3>
                </div>
                <div class="p-3 bg-amber-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] font-bold text-slate-400 lg:mt-6">
                Pending verification
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Growth Chart Widget (Placeholder) -->
        <div class="lg:col-span-2 glass-card p-8">
            <div class="flex justify-between items-center mb-8">
                <h4 class="text-xl font-display font-black">Sync Activity</h4>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 rounded-lg bg-white/5 text-[10px] font-bold uppercase">7 Days</button>
                    <button class="px-3 py-1 rounded-lg bg-blue-500/10 text-blue-500 text-[10px] font-bold uppercase">14 Days</button>
                </div>
            </div>
            <div class="h-64 w-full flex items-end space-x-2">
                @foreach([20, 45, 30, 65, 40, 80, 50, 90, 70, 85, 60, 100, 75, 95] as $val)
                    <div class="flex-1 bg-gradient-to-t from-blue-600 to-indigo-500 rounded-t-sm opacity-80 hover:opacity-100 transition-opacity" style="height: {{ $val }}%;"></div>
                @endforeach
            </div>
            <div class="flex justify-between mt-4 text-[10px] font-bold text-slate-500 px-2">
                <span>14 Days Ago</span>
                <span>Today</span>
            </div>
        </div>

        <!-- System Health Widget -->
        <div class="glass-card p-8 bg-gradient-to-br from-indigo-900/10 to-transparent">
            <h4 class="text-xl font-display font-black mb-6">System Health</h4>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold">Ollama AI Node</div>
                        <div class="text-[10px] text-slate-500">Processing lyrics & metadata</div>
                    </div>
                    <div class="flex items-center text-[10px] font-black text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">
                        ONLINE
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold">Core SQL Database</div>
                        <div class="text-[10px] text-slate-500">Latency: 14ms</div>
                    </div>
                    <div class="flex items-center text-[10px] font-black text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">
                        HEALTHY
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold">Storage Cluster</div>
                        <div class="text-[10px] text-slate-500">92% Availability</div>
                    </div>
                    <div class="flex items-center text-[10px] font-black text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">
                        ONLINE
                    </div>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-white/5 text-center">
                <button class="btn-premium text-[10px] text-white">RUN DEEP DIAGNOSTIC</button>
            </div>
        </div>
    </div>

    <!-- Latest Syncs -->
    <div class="glass-card overflow-hidden">
        <div class="p-8 border-b border-white/5 flex justify-between items-center">
            <h4 class="text-xl font-display font-black">Recent Activity Sync</h4>
            <a href="/admin/revisions" class="text-[10px] font-bold text-blue-500 uppercase tracking-widest hover:underline">View All Task History</a>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/[0.02]">
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Contributor</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Action</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Status</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500 text-right">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($recent_revisions as $rev)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-xs font-bold mr-3">
                                    {{ substr($rev->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold">{{ $rev->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm">Modified <span class="text-blue-400 font-bold">{{ $rev->article->title }}</span></div>
                            <div class="text-[10px] text-slate-500 truncate max-w-xs">{{ $rev->change_summary }}</div>
                        </td>
                        <td class="px-8 py-4">
                            @if($rev->status === 'approved')
                                <span class="px-2 py-1 rounded-md bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase">SYNCED</span>
                            @elseif($rev->status === 'pending')
                                <span class="px-2 py-1 rounded-md bg-amber-500/10 text-amber-500 text-[10px] font-black uppercase">PENDING</span>
                            @else
                                <span class="px-2 py-1 rounded-md bg-rose-500/10 text-rose-500 text-[10px] font-black uppercase">REJECTED</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right text-[10px] font-bold text-slate-500">
                            {{ $rev->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div><!-- End x-show loaded -->
</div>
