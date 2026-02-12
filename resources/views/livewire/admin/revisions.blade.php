<div class="space-y-8">
    
    <!-- Header & Filters -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            @section('header', 'Moderation Hub')
            @section('subheader', 'Verify and sync community records.')
        </div>

         <div class="flex items-center p-1 bg-[#161b22]/60 border border-white/10 rounded-xl">
            @foreach(['pending', 'approved', 'rejected'] as $status)
                <button wire:click="$set('filterStatus', '{{ $status }}')" 
                    class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === $status ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                    {{ $status }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Actual Content -->
    <div>
        <div class="bg-[#161b22]/60 backdrop-blur-xl border border-white/5 rounded-[24px] overflow-hidden shadow-2xl relative min-h-[400px]">
            
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 px-8 py-5 border-b border-white/5 bg-white/[0.02]">
                <div class="col-span-4 text-[10px] font-black text-white/40 uppercase tracking-widest">Target Content</div>
                <div class="col-span-3 text-[10px] font-black text-white/40 uppercase tracking-widest">Contributor</div>
                <div class="col-span-3 text-[10px] font-black text-white/40 uppercase tracking-widest">Modification</div>
                <div class="col-span-2 text-[10px] font-black text-white/40 uppercase tracking-widest text-right">Verification</div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-white/5">
                @forelse($revisions as $rev)
                    <div class="grid grid-cols-12 gap-4 px-8 py-4 items-center hover:bg-white/[0.02] transition-colors group">
                        
                        <!-- Target Content -->
                        <div class="col-span-4">
                            <div class="text-[14px] font-bold text-white group-hover:text-blue-400 transition-colors truncate">{{ $rev->article->title }}</div>
                            <span class="inline-flex items-center gap-1.5 mt-1 px-2 py-0.5 rounded border border-white/5 bg-white/5 text-[9px] font-black uppercase tracking-wider text-white/60">
                                {{ $rev->article->category }}
                            </span>
                        </div>

                        <!-- Contributor -->
                        <div class="col-span-3 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-bold text-xs border border-indigo-500/20">
                                {{ substr($rev->user->name, 0, 1) }}
                            </div>
                            <span class="text-[12px] font-bold text-white/80">{{ $rev->user->name }}</span>
                        </div>

                        <!-- Modification -->
                        <div class="col-span-3">
                            <div class="text-[13px] font-medium text-white/70 line-clamp-1" title="{{ $rev->change_summary }}">
                                {{ $rev->change_summary }}
                            </div>
                            <div class="text-[10px] text-white/30 font-mono mt-0.5">
                                {{ $rev->created_at->format('M d • H:i') }}
                            </div>
                        </div>

                        <!-- Verification -->
                        <div class="col-span-2 flex justify-end gap-2">
                             @if($rev->status === 'pending')
                                <button wire:click="approve({{ $rev->id }})" class="p-2 rounded-lg bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white transition-all shadow-lg shadow-emerald-500/10" title="Approve & Sync">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <button wire:click="reject({{ $rev->id }})" class="p-2 rounded-lg bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all shadow-lg shadow-rose-500/10" title="Reject">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            @else
                                <span class="px-2.5 py-1 rounded bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest {{ $rev->status === 'approved' ? 'text-emerald-500' : 'text-rose-500' }}">
                                    {{ $rev->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-24 text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-white font-bold text-lg">No records found</h3>
                        <p class="text-white/40 text-sm mt-1 max-w-xs mx-auto">The revision queue is currently empty for "{{ $filterStatus }}" items.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer / Pagination -->
            @if($revisions->count() > 0)
                <div class="px-8 py-4 border-t border-white/5 bg-white/[0.02]">
                    {{ $revisions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
