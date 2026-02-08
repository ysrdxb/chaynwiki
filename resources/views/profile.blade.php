<x-app-layout>
    <div class="min-h-screen pt-24 pb-12" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 400)">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 space-y-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-4xl font-black text-white uppercase tracking-tight leading-none mb-2">Settings</h1>
            </div>

            {{-- Skeleton Loading --}}
            <div x-show="!loaded" class="space-y-6">
                @for($i = 0; $i < 3; $i++)
                <div class="p-8 bg-[#161b22] border border-white/5 rounded-2xl animate-pulse">
                    <div class="h-6 w-48 bg-white/5 rounded mb-6"></div>
                    <div class="space-y-4">
                        <div class="h-10 w-full bg-white/5 rounded-xl"></div>
                        <div class="h-10 w-full bg-white/5 rounded-xl"></div>
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
                
                <div class="p-8 bg-[#161b22] border border-white/5 shadow-2xl rounded-2xl">
                    <livewire:profile.update-profile-information-form />
                </div>

                <div class="p-8 bg-[#161b22] border border-white/5 shadow-2xl rounded-2xl">
                    <livewire:profile.update-password-form />
                </div>

                <div class="p-8 bg-[#161b22] border border-white/5 shadow-2xl rounded-2xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
