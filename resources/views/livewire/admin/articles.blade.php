<div class="space-y-6" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    @section('header', 'Resource Index')
    @section('subheader', 'Manage all indexed music nodes and knowledge records.')

    <!-- Filters & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-96 relative">
            <input type="text" wire:model.live="search" placeholder="Search articles..." class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-10 py-3 text-sm focus:border-brand-500/50 focus:ring-0 outline-none transition-all">
            <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <div class="flex items-center gap-4 w-full md:w-auto">
            <select wire:model.live="filterCategory" class="bg-white/[0.03] border border-white/5 rounded-xl px-4 py-3 text-sm outline-none focus:border-brand-500/50">
                <option value="">All Categories</option>
                <option value="song">Songs</option>
                <option value="artist">Artists</option>
                <option value="genre">Genres</option>
                <option value="playlist">Playlists</option>
            </select>
            <a href="/wiki/create" class="btn-premium text-xs text-white whitespace-nowrap">INITIATE NEW RECORD</a>
        </div>
    </div>

    <!-- Skeleton Loading State -->
    <div x-show="!loaded" class="glass-card overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/[0.02]">
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-12"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-16"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-14"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-16"></div></th>
                    <th class="px-8 py-4"><div class="skeleton-v2 h-3 w-14"></div></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @for($i = 0; $i < 5; $i++)
                <tr>
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="skeleton-v2 w-10 h-10 rounded-lg mr-4"></div>
                            <div>
                                <div class="skeleton-v2 h-4 w-32 mb-2"></div>
                                <div class="skeleton-v2 h-3 w-24"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6"><div class="skeleton-v2 h-5 w-16 rounded-md"></div></td>
                    <td class="px-8 py-6"><div class="skeleton-v2 h-4 w-20"></div></td>
                    <td class="px-8 py-6"><div class="skeleton-v2 w-5 h-5 rounded"></div></td>
                    <td class="px-8 py-6 text-right"><div class="skeleton-v2 h-5 w-16 ml-auto"></div></td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Actual Content -->
    <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
    <!-- Articles Table -->
    <div class="glass-card overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/[0.02]">
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Record</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Category</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Author</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500">Featured</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase text-slate-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($articles as $article)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                @if($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" class="w-10 h-10 rounded-lg object-cover mr-4 border border-white/10">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center mr-4 border border-white/5">
                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-bold">{{ $article->title }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $article->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-2 py-1 rounded-md bg-white/5 text-[10px] font-black uppercase text-brand-400">
                                {{ $article->category }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm">{{ $article->user->name }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <button wire:click="toggleFeatured({{ $article->id }})" class="focus:outline-none">
                                @if($article->is_featured)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @else
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                @endif
                            </button>
                        </td>
                        <td class="px-8 py-6 text-right space-x-2">
                            <a href="/wiki/{{ $article->slug }}/edit" class="text-slate-500 hover:text-white transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button wire:click="deleteArticle({{ $article->id }})" wire:confirm="Are you sure you want to archive this?" class="text-rose-500/50 hover:text-rose-500 transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6 border-t border-white/5">
            {{ $articles->links() }}
        </div>
    </div>
    </div><!-- End x-show loaded -->
</div>
