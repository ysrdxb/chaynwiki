<div class="space-y-10">
    
    <!-- Header & Filters -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-600/10 border border-amber-500/20 flex items-center justify-center text-amber-500 shadow-xl shadow-amber-500/5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <h2 class="text-[28px] font-black text-white uppercase tracking-tighter leading-none">Moderation Hub</h2>
                <p class="text-white/40 text-[12px] font-bold uppercase tracking-widest mt-1.5">Verify and sync community-driven records</p>
            </div>
        </div>

         <div class="flex items-center p-1.5 bg-[#161b22] border border-white/10 rounded-[20px] shadow-2xl">
            @foreach(['pending', 'approved', 'rejected'] as $status)
                <button wire:click="$set('filterStatus', '{{ $status }}')" 
                    class="px-8 py-2.5 rounded-[14px] text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 {{ $filterStatus === $status ? 'bg-blue-600 text-white shadow-xl shadow-blue-600/20 scale-105' : 'text-white/30 hover:text-white hover:bg-white/5' }}">
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
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Target Entity</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Contributor</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Delta Payload</th>
                        <th class="px-10 py-6 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] text-right">Verification Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @forelse($revisions as $rev)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <!-- Target Content -->
                            <td class="px-10 py-5">
                                <div class="text-[15px] font-black text-white group-hover:text-blue-400 transition-colors truncate tracking-tight">{{ $rev->article->title }}</div>
                                <span class="inline-flex items-center gap-1.5 mt-1.5 px-2.5 py-1 rounded-lg border border-white/5 bg-white/5 text-[9px] font-black uppercase tracking-widest text-white/40">
                                    {{ $rev->article->category }}
                                </span>
                            </td>

                            <!-- Contributor -->
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-black text-xs border border-indigo-500/20 shadow-lg group-hover:scale-105 transition-transform">
                                        {{ substr($rev->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-[13px] font-bold text-white/80">{{ $rev->user->name }}</span>
                                </div>
                            </td>

                            <!-- Modification -->
                            <td class="px-10 py-5">
                                <div class="text-[14px] font-medium text-white/60 line-clamp-1 group-hover:text-white transition-colors" title="{{ $rev->change_summary }}">
                                    {{ $rev->change_summary }}
                                </div>
                                <div class="text-[9px] text-white/20 font-black uppercase tracking-[0.2em] mt-1.5">
                                    {{ $rev->created_at->format('M d • H:i') }}
                                </div>
                            </td>

                            <!-- Verification -->
                            <td class="px-10 py-5 text-right">
                                <div class="flex justify-end gap-2 group-hover:translate-x-0 transition-transform">
                                     @if($rev->status === 'pending')
                                        <button wire:click="approve({{ $rev->id }})" class="p-3 rounded-xl bg-emerald-500/10 text-emerald-500 border border-transparent hover:border-emerald-500/20 hover:bg-emerald-500 hover:text-white transition-all shadow-xl shadow-emerald-500/5" title="Synchronize Changes">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <button wire:click="reject({{ $rev->id }})" class="p-3 rounded-xl bg-rose-500/10 text-rose-500 border border-transparent hover:border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all shadow-xl shadow-rose-500/5" title="Discard Revision">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @else
                                        <span class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] {{ $rev->status === 'approved' ? 'text-emerald-500 shadow-[0_0_12px_rgba(16,185,129,0.2)]' : 'text-rose-500 shadow-[0_0_12px_rgba(244,63,94,0.2)]' }}">
                                            {{ $rev->status }}
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
                                         <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <svg class="w-10 h-10 text-white/10 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h3 class="text-white font-black text-xl uppercase tracking-tighter">Queue Normalized</h3>
                                    <p class="text-white/30 text-[12px] font-bold uppercase tracking-widest mt-2 max-w-xs mx-auto">No unverified "{{ $filterStatus }}" payloads detected in local storage.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        @if($revisions->count() > 0)
            <div class="px-10 py-6 border-t border-white/5 bg-white/[0.02]">
                {{ $revisions->links() }}
            </div>
        @endif
    </div>
</div>

