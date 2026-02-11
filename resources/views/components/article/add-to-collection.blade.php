@props(['article'])

<div x-data="{ 
    isOpen: false, 
    loading: false, 
    selectedCrate: '', 
    newCrateName: '',
    success: false,
    error: null,
    async addToCollection() {
        if (!this.selectedCrate && !this.newCrateName) return;
        this.loading = true;
        this.error = null;
        
        try {
            const response = await fetch('{{ route('api.crates.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    article_id: {{ $article->id }},
                    crate_id: this.selectedCrate,
                    new_crate_name: this.newCrateName
                })
            });
            
            const data = await response.json();
            if (data.success) {
                this.success = true;
                setTimeout(() => {
                    this.isOpen = false;
                    this.success = false;
                }, 2000);
            } else {
                this.error = data.message || 'Failed to save';
            }
        } catch (e) {
            this.error = 'Network error occurred';
        } finally {
            this.loading = false;
        }
    }
}" @keydown.escape.window="isOpen = false" class="relative">
    
    <button @click="isOpen = true" class="btn-figma-secondary !w-full !py-4 flex items-center justify-center gap-3 group">
        <svg class="w-5 h-5 text-blue-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        <span>Save to Library</span>
    </button>

    <!-- Modal Backdrop -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] flex items-center justify-center p-6">
        
        <!-- Modal Content -->
        <div @click.away="isOpen = false" 
             class="bg-[#161b22] border border-white/10 rounded-[2.5rem] w-full max-w-md overflow-hidden shadow-3xl relative">
            
            <div class="p-10">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family: 'Moderniz', sans-serif;">Save to collection</h3>
                    <button @click="isOpen = false" class="text-white/20 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                @auth
                    <div class="space-y-6">
                        @if(auth()->user()->crates->isNotEmpty())
                            <div>
                                <label class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-3 block">Existing collections</label>
                                <div class="grid gap-3">
                                    @foreach(auth()->user()->crates as $crate)
                                        <button @click="selectedCrate = '{{ $crate->id }}'; newCrateName = ''" 
                                                class="flex items-center justify-between p-4 rounded-2xl border transition-all"
                                                :class="selectedCrate == '{{ $crate->id }}' ? 'bg-blue-500/10 border-blue-500/50 text-white' : 'bg-white/5 border-white/5 text-white/40 hover:bg-white/10'">
                                            <span class="text-sm font-bold">{{ $crate->name }}</span>
                                            <div class="w-2 h-2 rounded-full" style="background-color: {{ $crate->color_accent ?? '#3b82f6' }}"></div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex items-center gap-4 my-8">
                                <div class="h-px bg-white/5 flex-1"></div>
                                <span class="text-[9px] font-black text-white/10 uppercase tracking-[0.3em]">OR</span>
                                <div class="h-px bg-white/5 flex-1"></div>
                            </div>
                        @endif

                        <div>
                            <label class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-3 block">Create new collection</label>
                            <input type="text" x-model="newCrateName" @input="selectedCrate = ''"
                                   placeholder="Collection name..." 
                                   class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm text-white placeholder-white/20 focus:outline-none focus:border-blue-500/50 transition-all">
                        </div>

                        <div class="pt-6">
                            <button @click="addToCollection" 
                                    :disabled="loading || (!selectedCrate && !newCrateName)"
                                    class="btn-figma-primary !w-full !py-5 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                <template x-if="success">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        <span>Saved Successfully</span>
                                    </div>
                                </template>
                                <template x-if="!success">
                                    <div class="flex items-center gap-3">
                                        <div x-show="loading" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin"></div>
                                        <span x-text="loading ? 'Saving...' : 'Confirm selection'"></span>
                                    </div>
                                </template>
                            </button>
                            
                            <p x-show="error" x-text="error" class="text-red-500 text-[10px] font-bold uppercase tracking-widest mt-4 text-center"></p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-8">
                            <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h4 class="text-white font-bold mb-2">Login Required</h4>
                        <p class="text-white/40 text-[11px] mb-8">You must be logged in to save topics to your library.</p>
                        <a href="{{ route('login') }}" class="btn-figma-primary !inline-flex !px-10">Log In</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
