<x-app-layout>
    <div class="min-h-screen pt-24 pb-12" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 400)">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 space-y-8">
            
            {{-- Header Refined --}}
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-4">
                    <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-lg text-[10px] font-black text-blue-500 uppercase tracking-widest">Profile settings</span>
                    <div class="h-[1px] flex-1 bg-white/5"></div>
                </div>
                <h1 class="text-[64px] font-black text-white uppercase tracking-tightest leading-[0.85]" style="font-family: 'Plus Jakarta Sans', sans-serif;">CONTRIBUTOR <br/> <span class="text-blue-500">SETTINGS</span> / CONFIG</h1>
            </div>

            {{-- Skeleton Loading Refined --}}
            <div x-show="!loaded" class="space-y-8">
                @for($i = 0; $i < 3; $i++)
                <div class="p-12 bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[3rem] animate-pulse">
                    <div class="h-8 w-64 bg-white/5 rounded-xl mb-10"></div>
                    <div class="space-y-6">
                        <div class="h-16 w-full bg-white/5 rounded-2xl"></div>
                        <div class="h-16 w-full bg-white/5 rounded-2xl"></div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- Actual Content --}}
            <div x-show="loaded" 
                 x-transition:enter="transition ease-out duration-500" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-8" 
                 style="display: none;">
                
                {{-- Vault Dashboard --}}
                <div class="card-premium h-auto !bg-transparent !p-0 border-0 shadow-none">
                    <livewire:profile.vault-dashboard />
                </div>
                
                <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-12 rounded-[3.5rem] border-white/5 hover:border-blue-500/20 shadow-3xl transition-all duration-700">
                    <livewire:profile.update-profile-information-form />
                </div>

                <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-12 rounded-[3.5rem] border-white/5 hover:border-blue-500/20 shadow-3xl transition-all duration-700">
                    <livewire:profile.update-password-form />
                </div>

                <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-12 rounded-[3.5rem] border-white/5 hover:border-blue-500/20 shadow-3xl transition-all duration-700">
                    <div class="mb-8">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="px-3 py-1 bg-green-500/10 border border-green-500/20 rounded-lg text-[10px] font-black text-green-500 uppercase tracking-widest">External Connectivity</span>
                            <div class="h-[1px] flex-1 bg-white/5"></div>
                        </div>
                        <h2 class="text-2xl font-black text-white uppercase tracking-tightest">Sonic Bridge / <span class="text-green-500">Spotify</span></h2>
                    </div>
                    <livewire:spotify-now-playing :user="auth()->user()" />
                </div>

                <div class="card-premium h-auto !bg-red-500/[0.02] backdrop-blur-sm !p-12 rounded-[3.5rem] border-red-500/10 hover:border-red-500/30 shadow-3xl transition-all duration-700">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
