<div class="space-y-6">
    @section('header', 'Moderation Hub')
    @section('subheader', 'Verify and sync community records to the primary knowledge graph.')

    <!-- Filters -->
    <div class="flex gap-2">
        @foreach(['pending', 'approved', 'rejected'] as $status)
            <button wire:click="$set('filterStatus', '{{ $status }}')" 
                class="px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition-all {{ $filterStatus === $status ? 'bg-brand-500/20 text-brand-500 border border-brand-500/30' : 'bg-white/5 text-slate-500 hover:bg-white/10' }}">
                {{ $status }}
            </button>
        @endforeach
    </div>

    <!-- Revisions Queue -->
    <div class="glass-card overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/[0.02]">
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Record Source</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Contributor</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Summary of Change</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500 text-right">Verification</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($revisions as $rev)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold">{{ $rev->article->title }}</div>
                            <div class="text-[10px] text-slate-500 uppercase">{{ $rev->article->category }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xs font-bold mr-3">
                                    {{ substr($rev->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm">{{ $rev->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm text-slate-300">{{ $rev->change_summary }}</div>
                            <div class="text-[10px] text-slate-500 mt-1">{{ $rev->created_at->format('M d, Y • H:i') }}</div>
                        </td>
                        <td class="px-8 py-6 text-right space-x-2">
                            @if($rev->status === 'pending')
                                <button wire:click="approve({{ $rev->id }})" class="bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase transition-all">APPROVE & SYNC</button>
                                <button wire:click="reject({{ $rev->id }})" class="bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase transition-all">REJECT</button>
                            @else
                                <span class="text-[10px] font-bold uppercase text-slate-600">{{ $rev->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-slate-500">
                            <svg class="w-12 h-12 mx-auto mb-4 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <div class="text-sm">Transmission clear. No pending records.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6 border-t border-white/5">
            {{ $revisions->links() }}
        </div>
    </div>
</div>
