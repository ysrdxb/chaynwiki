<?php

use Livewire\Volt\Component;
use App\Models\Crate;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Article $article;
    public $isOpen = false;
    public $loading = false;
    public $selectedCrate = '';
    public $newCrateName = '';
    public $success = false;
    public $error = null;
    public $isPublic = false;

    public function addToCollection()
    {
        if (!Auth::check()) return;
        if (!$this->selectedCrate && !$this->newCrateName) return;

        $this->loading = true;
        $this->error = null;

        try {
            $user = Auth::user();

            if ($this->newCrateName) {
                $crate = $user->crates()->create([
                    'name' => $this->newCrateName,
                    'description' => 'Personal collection',
                    'color_accent' => '#3b82f6',
                    'is_public' => $this->isPublic
                ]);
                $this->selectedCrate = $crate->id;
            }

            $crate = Crate::findOrFail($this->selectedCrate);
            
            // Permission check: Owner or Collaborator
            if ($crate->user_id !== $user->id && !$user->collaboratedCrates()->where('crate_id', $crate->id)->exists()) {
                throw new \Exception('You do not have permission to edit this collection.');
            }

            // Check if already in crate to avoid duplicates if needed, but attach handles sync
            $crate->articles()->syncWithoutDetaching([$this->article->id]);

            $this->success = true;
            $this->dispatch('toast', message: 'Saved to library');
            
            sleep(1); // Brief pause for UX
            $this->isOpen = false;
            $this->success = false;
            $this->newCrateName = '';
            $this->selectedCrate = '';
            $this->isPublic = false;

        } catch (\Exception $e) {
            $this->error = 'Failed to save: ' . $e->getMessage();
        } finally {
            $this->loading = false;
        }
    }
}; ?>

<div class="relative">
    <button wire:click="$set('isOpen', true)" class="btn-figma-secondary !w-full !py-4 flex items-center justify-center gap-3 group">
        <svg class="w-5 h-5 text-blue-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        <span class="text-xs font-bold tracking-widest">Save to Library</span>
    </button>

    @if($isOpen)
    @teleport('body')
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-[#0d1117]/95 backdrop-blur-2xl z-[99999] flex items-center justify-center p-6"
             x-data x-on:keydown.escape.window="$wire.isOpen = false">
            
            <!-- Modal Content -->
            <div @click.away="$wire.isOpen = false" 
                 class="bg-[#161b22] border border-white/10 rounded-[2.5rem] w-full max-w-md overflow-hidden shadow-[0_0_100px_rgba(0,0,0,0.9),0_0_40px_rgba(59,130,246,0.15)] relative transition-all duration-300">
                
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family: 'Moderniz', sans-serif;">Save to collection</h3>
                        <button wire:click="$set('isOpen', false)" class="text-white/20 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    @auth
                        <div class="space-y-6">
                            @php 
                                $userCrates = auth()->user()->crates;
                                $collaboratedCrates = auth()->user()->collaboratedCrates;
                                $allCrates = $userCrates->merge($collaboratedCrates);
                            @endphp
                            @if($allCrates->isNotEmpty())
                                <div>
                                    <label class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-3 block">Available collections</label>
                                    <div class="grid gap-3 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach($allCrates as $crate)
                                            <button wire:click="$set('selectedCrate', '{{ $crate->id }}'); $set('newCrateName', '')"
                                                    class="flex items-center justify-between p-4 rounded-2xl border transition-all duration-300 {{ $selectedCrate == $crate->id ? 'bg-blue-500/10 border-blue-500/50 text-white' : 'bg-white/5 border-white/5 text-white/40 hover:bg-white/10 hover:border-white/10' }}">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-sm font-bold">{{ $crate->name }}</span>
                                                    @if($crate->user_id !== auth()->id())
                                                        <span class="px-1.5 py-0.5 rounded text-[7px] font-black bg-purple-500/20 text-purple-400 uppercase tracking-widest border border-purple-500/10">Collab</span>
                                                    @endif
                                                    @if($crate->is_public)
                                                        <span class="px-1.5 py-0.5 rounded text-[7px] font-black bg-blue-500/20 text-blue-400 uppercase tracking-widest border border-blue-500/10">Public</span>
                                                    @endif
                                                </div>
                                                <div class="w-2 h-2 rounded-full shadow-[0_0_8px_currentColor]" style="background-color: {{ $crate->color_accent ?? '#3b82f6' }}; color: {{ $crate->color_accent ?? '#3b82f6' }}"></div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 my-6">
                                    <div class="h-px bg-white/5 flex-1"></div>
                                    <span class="text-[9px] font-black text-white/10 uppercase tracking-[0.3em]">OR</span>
                                    <div class="h-px bg-white/5 flex-1"></div>
                                </div>
                            @endif

                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-1 block">Create new collection</label>
                                <div class="flex items-center gap-3">
                                    <div class="flex-1">
                                        <input type="text" wire:model.live="newCrateName" 
                                               placeholder="Collection name..." 
                                               class="input-unified !py-4 !px-6 !text-sm !font-bold">
                                    </div>
                                    <div class="shrink-0">
                                        <button type="button" 
                                                wire:click="$toggle('isPublic')"
                                                class="flex flex-col items-center gap-1 group">
                                            <div class="w-10 h-6 rounded-full relative transition-all duration-300 {{ $isPublic ? 'bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.3)]' : 'bg-white/10' }}">
                                                <div class="absolute top-1 left-1 w-4 h-4 rounded-full bg-white transition-all duration-300 {{ $isPublic ? 'translate-x-4' : '' }}"></div>
                                            </div>
                                            <span class="text-[7px] font-black uppercase tracking-widest {{ $isPublic ? 'text-blue-400' : 'text-white/20' }}">{{ $isPublic ? 'Public' : 'Private' }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button wire:click="addToCollection" 
                                        @disabled($loading || (!$selectedCrate && !$newCrateName))
                                        class="btn-figma-primary !w-full !py-5 flex items-center justify-center gap-3 disabled:opacity-30 disabled:grayscale disabled:cursor-not-allowed transition-all duration-300 group">
                                    @if($success)
                                        <svg class="w-5 h-5 text-[#0d1117] animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-[#0d1117]">Saved to Library</span>
                                    @else
                                        <div wire:loading wire:target="addToCollection" class="w-4 h-4 border-2 border-[#0d1117]/20 border-t-[#0d1117] rounded-full animate-spin"></div>
                                        <span wire:loading.remove wire:target="addToCollection" class="text-[#0d1117] group-hover:scale-105 transition-transform">{{ $selectedCrate || $newCrateName ? 'Save to Collection' : 'Select a collection' }}</span>
                                        <span wire:loading wire:target="addToCollection" class="text-[#0d1117]">Saving...</span>
                                    @endif
                                </button>
                                
                                @if($error)
                                    <p class="text-red-500 text-[10px] font-bold uppercase tracking-widest mt-4 text-center">{{ $error }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-8 border border-white/5 shadow-inner">
                                <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <h4 class="text-white font-bold mb-2">Login Required</h4>
                            <p class="text-white/40 text-[11px] mb-8 leading-relaxed">Join the community to start building your personal music library.</p>
                            <a href="{{ route('login') }}" class="btn-figma-primary !inline-flex !px-12 !py-4 shadow-xl">Secure Log In</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    @teleport('body')
    @endif
</div>
