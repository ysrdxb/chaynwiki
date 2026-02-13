<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public User $user;
    public $collection = [];

    public function mount(User $user)
    {
        $this->user = $user;
        
        // Fetch user's "Crate" items. 
        // For now, we use their published Articles as their specific collection.
        // In the future, this could be $user->wantlist or $user->collection
        $this->collection = $user->articles()
            ->where('status', 'published')
            ->latest()
            ->take(20) // Limit for performance of 3D view
            ->get();
    }
};
?>

<section class="bg-[#0d1117] py-24 border-t border-white/5 overflow-hidden relative">
    <div class="absolute inset-0 bg-gradient-to-b from-[#161b22]/40 to-[#0d1117] pointer-events-none"></div>
    
    <div class="max-w-[1400px] mx-auto px-8 relative z-10">
        <div class="flex items-center justify-between mb-16">
            <h2 class="text-3xl font-black text-white tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Digital Crate <span class="text-white/10 ml-4 font-black">/ Collection</span>
            </h2>
            <span class="px-4 py-2 bg-purple-500/10 border border-purple-500/20 rounded-xl text-[10px] font-black text-purple-400 tracking-widest uppercase">
                {{ count($collection) }} Vinyls
            </span>
        </div>

        @if($collection->isNotEmpty())
            <x-wiki.crate :items="$collection" />
        @else
            <div class="flex flex-col items-center justify-center py-32 border border-dashed border-white/10 rounded-[3rem] bg-white/[0.02]">
                <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <p class="text-white/30 text-sm font-black tracking-widest uppercase">Crate is empty</p>
            </div>
        @endif
    </div>
</section>