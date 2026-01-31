<?php

use Livewire\Volt\Component;
use App\Models\Article;
use App\Models\Crate;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public Article $article;
    public $isOpen = false;
    public $newCrateName = '';
    public $selectedCrateId = '';

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen && Auth::user()->crates->isEmpty()) {
            $this->newCrateName = 'My First Archive';
        }
    }

    public function addToCrate($crateId = null)
    {
        $crateId = $crateId ?: $this->selectedCrateId;
        
        if (!$crateId) {
            $crate = Auth::user()->crates()->create([
                'name' => $this->newCrateName ?: 'New Crate',
                'description' => 'Personal archive collection'
            ]);
            $crateId = $crate->id;
        }

        $this->article->crates()->syncWithoutDetaching([$crateId => ['notes' => 'Added via Elite Crate interface']]);

        $this->isOpen = false;
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Article indexed in ' . Crate::find($crateId)->name
        ]);
    }
    
    public function getCratesProperty()
    {
        return Auth::user()->crates;
    }
};
?>

<div class="relative">
    <button 
        wire:click="toggleModal"
        class="w-full py-4 bg-secondary border border-white/5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:border-blue-500/30 transition-all flex items-center justify-center gap-3 group"
    >
        <span class="text-white/40 group-hover:text-blue-400 transition-colors">Add to Crate</span>
        <div class="w-4 h-4 rounded-full bg-blue-500/10 flex items-center justify-center">
            <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
        </div>
    </button>

    <div 
        x-show="$wire.isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="absolute right-0 bottom-full mb-4 w-72 bg-[#0D0D1A] border border-white/10 rounded-3xl shadow-3xl p-6 z-[110]"
        style="display: none;"
    >
        <h3 class="text-sm font-black text-white italic uppercase tracking-tighter mb-4">Indexing Protocol</h3>
        
        <div class="space-y-4">
            {{-- Existing Crates --}}
            @if(Auth::user()->crates->isNotEmpty())
                <div class="space-y-2">
                    <label class="text-[9px] font-black text-white/20 uppercase tracking-widest pl-1">Target Crate</label>
                    <select wire:model="selectedCrateId" class="w-full bg-black/40 border border-white/5 rounded-xl px-4 py-3 text-[10px] text-white focus:border-blue-500 outline-none appearance-none">
                        <option value="">Select Crate...</option>
                        @foreach(Auth::user()->crates as $crate)
                            <option value="{{ $crate->id }}">{{ $crate->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button wire:click="addToCrate" class="w-full py-3 bg-blue-500 text-white font-black text-[9px] uppercase tracking-widest rounded-xl hover:bg-blue-600 transition-all">
                    Confirm Sync
                </button>
                <div class="flex items-center gap-3 py-2">
                    <div class="flex-1 h-px bg-white/5"></div>
                    <span class="text-[8px] font-black text-white/10 uppercase">OR</span>
                    <div class="flex-1 h-px bg-white/5"></div>
                </div>
            @endif

            {{-- New Crate --}}
            <div class="space-y-2">
                <label class="text-[9px] font-black text-white/20 uppercase tracking-widest pl-1">Generate New Crate</label>
                <input wire:model="newCrateName" type="text" placeholder="Crate Designation..." class="w-full bg-black/40 border border-white/5 rounded-xl px-4 py-3 text-[10px] text-white placeholder:text-white/10 focus:border-blue-500 outline-none">
            </div>
            <button wire:click="addToCrate()" class="w-full py-3 bg-white text-black font-black text-[9px] uppercase tracking-widest rounded-xl hover:scale-[1.02] transition-all">
                Create & Sync
            </button>
        </div>

        <button @click="$wire.isOpen = false" class="absolute top-4 right-4 text-white/10 hover:text-white">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>