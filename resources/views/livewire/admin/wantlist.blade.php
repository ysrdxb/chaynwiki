<div class="space-y-10">
    
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 shadow-xl shadow-emerald-500/5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <h2 class="text-[28px] font-black text-white uppercase tracking-tighter leading-none">Knowledge Wantlist</h2>
                <p class="text-white/40 text-[12px] font-bold uppercase tracking-widest mt-1.5">Community-driven data acquisition targets</p>
            </div>
        </div>

         <div class="flex items-center p-1.5 bg-[#161b22] border border-white/10 rounded-[20px] shadow-2xl">
            @foreach(['pending', 'fulfilled', 'rejected'] as $status)
                <button wire:click="$set('filterStatus', '{{ $status }}')" 
                    class="px-8 py-2.5 rounded-[14px] text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 {{ $filterStatus === $status ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20 scale-105' : 'text-white/30 hover:text-white hover:bg-white/5' }}">
                    {{ $status }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Actual Content -->
    <div class="bg-[#161b22] border border-white/5 rounded-[32px] overflow-hidden shadow-2xl relative min-h-[400px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Requested Asset</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Community Heat</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Originator</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] text-right">Acquisition</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @forelse($requests as $req)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <!-- Target Asset -->
                            <td class="px-10 py-5">
                                <div class="text-[15px] font-black text-white group-hover:text-emerald-400 transition-colors truncate tracking-tight">{{ $req->title }}</div>
                                <span class="inline-flex items-center gap-1.5 mt-1.5 px-2.5 py-1 rounded-lg border border-white/5 bg-white/5 text-[9px] font-black uppercase tracking-widest text-white/40">
                                    {{ $req->category }}
                                </span>
                            </td>

                            <!-- Community Heat -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="flex -space-x-2">
                                        {{-- Placeholder for voter avatars? --}}
                                        <div class="w-8 h-8 rounded-full border-2 border-[#161b22] bg-blue-600/20 flex items-center justify-center text-[10px] font-black text-blue-400">+{{ $req->votes }}</div>
                                    </div>
                                    <div class="h-1.5 w-24 bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]" style="width: {{ min($req->votes * 10, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Contributor -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-black text-white/60 uppercase">
                                        {{ substr($req->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-[12px] font-bold text-white/60">{{ $req->user->name ?? 'Anonymous' }}</span>
                                </div>
                            </td>

                            <!-- Operations -->
                            <td class="px-10 py-5 text-right">
                                <div class="flex justify-end gap-2 group-hover:translate-x-0 transition-transform">
                                     @if($req->status === 'pending')
                                        <button wire:click="fulfill({{ $req->id }})" class="px-6 py-2.5 rounded-xl bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-emerald-500/20 flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            Fulfill entry
                                        </button>
                                        <button wire:click="delete({{ $req->id }})" class="p-2.5 rounded-xl hover:bg-rose-500/10 hover:text-rose-500 border border-transparent hover:border-rose-500/20 transition-all text-white/20" title="Discard Request">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @else
                                        <span class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] {{ $req->status === 'fulfilled' ? 'text-emerald-500 shadow-[0_0_12px_rgba(16,185,129,0.2)]' : 'text-rose-500' }}">
                                            {{ $req->status }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="flex flex-col items-center justify-center py-32 text-center">
                                    <div class="w-20 h-20 rounded-[24px] bg-white/5 flex items-center justify-center mb-6 shadow-2xl relative overflow-hidden group">
                                        <svg class="w-10 h-10 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h3 class="text-white font-black text-xl uppercase tracking-tighter">Wantlist Cleared</h3>
                                    <p class="text-white/30 text-[12px] font-bold uppercase tracking-widest mt-2 max-w-xs mx-auto">All community requests have been processed or fulfilled.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        @if($requests->count() > 0)
            <div class="px-10 py-6 border-t border-white/5 bg-white/[0.02]">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
