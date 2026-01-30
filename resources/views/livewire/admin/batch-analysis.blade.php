<div class="space-y-8">
    <div class="glass-card p-8">
        <h2 class="text-2xl font-bold mb-4">Batch Lyric Analysis</h2>
        <p class="text-slate-400 mb-8">Select multiple songs to trigger AI-driven themes, mood, and rhyme analysis.</p>

        @if(session()->has('message'))
            <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-xl">
                {{ session('message') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="mb-4 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-500 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @if($results)
            <div class="mb-8 p-6 bg-brand-500/10 border border-brand-500/20 rounded-2xl">
                <h3 class="font-bold mb-2">Processing Results</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-black/20 p-4 rounded-xl">
                        <div class="text-xs text-slate-500 uppercase tracking-widest">Total</div>
                        <div class="text-2xl font-black">{{ $results['total'] }}</div>
                    </div>
                    <div class="bg-black/20 p-4 rounded-xl text-emerald-500">
                        <div class="text-xs text-slate-500 uppercase tracking-widest">Success</div>
                        <div class="text-2xl font-black">{{ $results['processed'] }}</div>
                    </div>
                    <div class="bg-black/20 p-4 rounded-xl text-rose-500">
                        <div class="text-xs text-slate-500 uppercase tracking-widest">Failed</div>
                        <div class="text-2xl font-black">{{ $results['failed'] }}</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white/[0.02]">
                        <th class="px-6 py-4 w-10">
                            <input type="checkbox" class="rounded border-white/10 bg-white/5 text-brand-500 focus:ring-brand-500">
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase text-slate-500">Title</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase text-slate-500">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase text-slate-500">Analysis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($articles as $article)
                        <tr class="hover:bg-white/[0.01]">
                            <td class="px-6 py-4">
                                <input type="checkbox" wire:model.live="selectedArticles" value="{{ $article->id }}" class="rounded border-white/10 bg-white/5 text-brand-500 focus:ring-brand-500">
                            </td>
                            <td class="px-6 py-4 font-bold">{{ $article->title }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $article->status === 'published' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-slate-500/10 text-slate-500' }}">
                                    {{ $article->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($article->analysis)
                                    <span class="text-emerald-500 text-xs flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                        Complete
                                    </span>
                                @else
                                    <span class="text-slate-500 text-xs">No analysis</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 pt-8 border-t border-white/5 flex justify-between items-center">
            <div class="text-sm text-slate-500">
                Selected: <span class="font-bold text-white">{{ count($selectedArticles) }}</span> articles
            </div>
            <button wire:click="process" wire:loading.attr="disabled" class="btn-premium px-8 py-3 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-brand-500/20 disabled:opacity-50">
                <span wire:loading.remove wire:target="process">Trigger AI Job</span>
                <span wire:loading wire:target="process">Processing with Ollama...</span>
            </button>
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
</div>
