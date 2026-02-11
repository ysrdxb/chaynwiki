<?php

use Livewire\Volt\Component;
use App\Models\Crate;
use App\Models\Follower;
use App\Models\CrateCollaborator;
use App\Services\ReputationService;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'trending'; // trending, newest, followed

    public function with()
    {
        $query = Crate::where('is_public', true)
            ->with(['user', 'articles'])
            ->withCount(['followers', 'articles']);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'trending') {
            $query->orderByDesc('followers_count')->orderByDesc('views_count');
        } elseif ($this->filter === 'newest') {
            $query->latest();
        } elseif ($this->filter === 'followed' && Auth::check()) {
            $query->whereHas('followers', function($q) {
                $q->where('user_id', Auth::id());
            });
        }

        return [
            'crates' => $query->paginate(12)
        ];
    }

    public function toggleFollow($crateId)
    {
        if (!Auth::check()) return redirect()->route('login');

        $crate = Crate::findOrFail($crateId);
        $user = Auth::user();
        $reputation = app(ReputationService::class);

        $existingFollow = Follower::where('user_id', $user->id)
            ->where('followable_id', $crate->id)
            ->where('followable_type', Crate::class)
            ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            $reputation->deduct($crate->user, ReputationService::POINTS_CRATE_FOLLOW, 'Lost a follower on collection: ' . $crate->name);
            $this->dispatch('toast', message: 'Unfollowed collection');
        } else {
            Follower::create([
                'user_id' => $user->id,
                'followable_id' => $crate->id,
                'followable_type' => Crate::class
            ]);
            $reputation->award($crate->user, ReputationService::POINTS_CRATE_FOLLOW, 'New follower on collection: ' . $crate->name);
            $this->dispatch('toast', message: 'Now following collection');
        }
    }

    public function requestCollaboration($crateId)
    {
        if (!Auth::check()) return redirect()->route('login');

        $crate = Crate::findOrFail($crateId);
        $user = Auth::user();

        if ($user->reputation < 500) {
            $this->dispatch('toast', message: 'Requirement: 500+ Reputation', type: 'error');
            return;
        }

        if ($crate->user_id === $user->id) {
            $this->dispatch('toast', message: 'You are the owner', type: 'info');
            return;
        }

        $existing = CrateCollaborator::where('crate_id', $crate->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $this->dispatch('toast', message: 'Already a contributor', type: 'info');
            return;
        }

        // For now, auto-approve for trusted users if the crate is public
        CrateCollaborator::create([
            'crate_id' => $crate->id,
            'user_id' => $user->id,
            'role' => 'contributor'
        ]);

        $this->dispatch('toast', message: 'You are now a contributor!');
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedFilter()
    {
        $this->resetPage();
    }
};
?>

<div class="space-y-12">
    <!-- Header/Search Area -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-8">
        <div>
            <h2 class="text-4xl font-black text-white tracking-tighter uppercase mb-2" style="font-family: 'Moderniz', sans-serif;">Community <span class="text-blue-500">Crates</span></h2>
            <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">Explore verified collections from top contributors</p>
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:w-80">
                <input type="text" wire:model.live.debounce.300ms="search" 
                       class="w-full bg-[#161b22]/40 border border-white/5 rounded-2xl px-6 py-4 text-xs font-bold text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder:text-white/10 shadow-inner"
                       placeholder="Search collections...">
                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <div class="flex bg-[#161b22]/40 border border-white/5 rounded-2xl p-1.5 shadow-xl">
                <button wire:click="$set('filter', 'trending')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'trending' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/20' : 'text-white/20 hover:text-white' }}">Trending</button>
                <button wire:click="$set('filter', 'newest')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'newest' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/20' : 'text-white/20 hover:text-white' }}">Newest</button>
                @auth
                    <button wire:click="$set('filter', 'followed')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'followed' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/20' : 'text-white/20 hover:text-white' }}">Following</button>
                @endauth
            </div>
        </div>
    </div>

    <!-- Crates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($crates as $crate)
            <div class="group relative" wire:key="crate-{{ $crate->id }}">
                <!-- Hover Glow -->
                <div class="absolute inset-0 bg-blue-500/5 rounded-[2.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                
                <div class="card-premium-unified !bg-[#161b22]/40 backdrop-blur-sm !p-8 relative overflow-hidden flex flex-col h-full border border-white/5 group-hover:border-blue-500/20 transition-all duration-500 shadow-2xl">
                    <!-- Accent Line -->
                    <div class="absolute top-0 left-0 w-full h-1" style="background-color: {{ $crate->color_accent ?? '#3b82f6' }}"></div>

                    <!-- Header -->
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-xl shadow-inner border border-white/5 transition-transform group-hover:scale-110 duration-500" style="color: {{ $crate->color_accent ?? '#3b82f6' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        
                        <div class="flex flex-col items-end gap-2 relative z-20">
                             @auth
                                @if(auth()->id() !== $crate->user_id)
                                    <div class="flex items-center gap-2">
                                        @php
                                            $isContributor = auth()->user()->collaboratedCrates()->where('crate_id', $crate->id)->exists();
                                        @endphp

                                        @if(!$isContributor && auth()->user()->reputation >= 500)
                                            <button wire:click="requestCollaboration({{ $crate->id }})" 
                                                    class="px-3 py-1.5 rounded-xl bg-purple-500/10 border border-purple-500/20 text-[9px] font-black text-purple-400 uppercase tracking-widest hover:bg-purple-500 hover:text-white transition-all shadow-lg">
                                                Contribute
                                            </button>
                                        @elseif($isContributor)
                                            <span class="px-3 py-1.5 rounded-xl bg-green-500/10 border border-green-500/20 text-[9px] font-black text-green-400 uppercase tracking-widest shadow-lg">
                                                Contributor
                                            </span>
                                        @endif

                                        <button wire:click="toggleFollow({{ $crate->id }})" 
                                                class="p-2.5 rounded-xl transition-all shadow-xl {{ $crate->isFollowedBy(auth()->user()) ? 'bg-blue-500 text-white shadow-blue-500/20' : 'bg-white/5 border border-white/5 text-white/20 hover:text-white hover:bg-white/10' }}">
                                            @if($crate->isFollowedBy(auth()->user()))
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                            @endif
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-white tracking-tightest mb-2" style="font-family: 'Moderniz', sans-serif;">{{ $crate->name }}</h3>
                        <p class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-6">{{ $crate->articles_count ?? 0 }} Topics collected</p>
                        <p class="text-white/40 text-[11px] font-bold leading-relaxed line-clamp-2 min-h-[3rem]">{{ $crate->description ?? 'A curated collection of musical records and insights.' }}</p>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-8 border-t border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#161b22] border border-white/10 flex items-center justify-center text-[10px] font-black text-white/20 overflow-hidden shadow-inner">
                                @if($crate->user->avatar)
                                    <img src="{{ $crate->user->avatar }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                @else
                                    {{ strtoupper(substr($crate->user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-white uppercase tracking-widest">{{ $crate->user->name }}</span>
                                <span class="text-[8px] font-black text-white/10 uppercase tracking-[0.2em]">{{ $crate->user->rank_name ?? 'NOVICE' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1.5 grayscale opacity-30 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span class="text-[9px] font-black text-white tracking-widest">{{ number_format($crate->views_count) }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-blue-500/60 group-hover:text-blue-400 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                <span class="text-[9px] font-black tracking-widest">{{ number_format($crate->followers_count) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay Link -->
                    <a href="{{ route('wiki.index') }}?crate={{ $crate->slug }}" class="absolute inset-0 z-10" wire:navigate></a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center">
                <div class="w-20 h-20 rounded-full bg-white/5 border border-white/5 flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <svg class="w-10 h-10 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-white font-bold mb-2 uppercase tracking-widest text-[12px]">No collection found</h3>
                <p class="text-white/20 text-[10px] tracking-widest">Adjust your search or filters to find more crates</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16">
        {{ $crates->links() }}
    </div>
</div>
