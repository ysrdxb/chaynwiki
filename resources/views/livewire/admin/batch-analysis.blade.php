<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase">Batch Analysis</h2>
            <p class="text-white/50 mt-1">Trigger AI-driven themes, mood, and rhyme analysis for multiple songs.</p>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-bold">{{ session('message') }}</span>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-6 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl flex items-center gap-4">
             <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    @if($results)
        <div class="bg-[#161b22] border border-white/5 rounded-2xl p-8 shadow-2xl">
            <h3 class="font-bold text-white uppercase tracking-widest text-xs mb-6">Processing Results</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#0d1117] border border-white/5 p-6 rounded-xl">
                    <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-1">Total Processed</div>
                    <div class="text-3xl font-black text-white">{{ $results['total'] }}</div>
                </div>
                <div class="bg-emerald-500/5 border border-emerald-500/10 p-6 rounded-xl">
                    <div class="text-[10px] font-bold text-emerald-500/60 uppercase tracking-widest mb-1">Successful</div>
                    <div class="text-3xl font-black text-emerald-400">{{ $results['processed'] }}</div>
                </div>
                <div class="bg-red-500/5 border border-red-500/10 p-6 rounded-xl">
                    <div class="text-[10px] font-bold text-red-500/60 uppercase tracking-widest mb-1">Failed</div>
                    <div class="text-3xl font-black text-red-400">{{ $results['failed'] }}</div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-[#161b22] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="bg-[#0d1117]/50 border-b border-white/5 px-8 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="text-sm text-white/60 font-medium">
                Selected: <span class="font-bold text-white">{{ count($selectedArticles) }}</span> articles
            </div>
            
            <button 
                wire:click="process" 
                wire:loading.attr="disabled" 
                class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-3">
                <span wire:loading.remove wire:target="process">Trigger AI Job</span>
                <span wire:loading wire:target="process" class="flex items-center gap-2">
                    <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Processing...
                </span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-8 py-5 w-10">
                            {{-- Global Checkbox could go here --}}
                        </th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-wider text-white/40">Title</th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-wider text-white/40">Status</th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-wider text-white/40">Analysis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($articles as $article)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-5">
                                <input type="checkbox" wire:model.live="selectedArticles" value="{{ $article->id }}" class="rounded border-white/10 bg-[#0d1117] text-blue-500 focus:ring-offset-0 focus:ring-blue-500/50 w-4 h-4 cursor-pointer">
                            </td>
                            <td class="px-8 py-5">
                                <div class="font-bold text-white group-hover:text-blue-400 transition-colors">{{ $article->title }}</div>
                                <div class="text-xs text-white/30 font-mono mt-0.5 max-w-xs truncate">{{ $article->slug }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $article->status === 'published' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-white/5 text-white/40 border border-white/10' }}">
                                    {{ $article->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                @if($article->analysis)
                                    <div class="flex items-center gap-2 text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-xs font-bold uppercase tracking-wide">Complete</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 text-white/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-xs font-bold uppercase tracking-wide">Pending</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 border-t border-white/5">
            {{ $articles->links() }}
        </div>
    </div>
</div>
