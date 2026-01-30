<x-app-layout>
    <div class="pt-24 pb-12" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-10 px-4 sm:px-0">
                <h1 class="text-3xl md:text-5xl font-black text-white uppercase italic tracking-tighter leading-none mb-3">Settings</h1>
                <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">Manage your node configuration and preferences.</p>
            </div>

            <!-- Skeleton Loading State -->
            <div x-show="!loaded" class="space-y-6">
                @for($i = 0; $i < 3; $i++)
                <div class="p-6 sm:p-8 bg-secondary border border-white/5 shadow-2xl rounded-2xl">
                    <div class="max-w-xl space-y-4">
                        <div class="skeleton-v2 h-5 w-32 mb-6"></div>
                        <div class="skeleton-v2 h-3 w-full"></div>
                        <div class="space-y-3">
                            <div class="skeleton-v2 h-3 w-16"></div>
                            <div class="skeleton-v2 h-10 w-full rounded-xl"></div>
                        </div>
                        <div class="skeleton-v2 h-8 w-20 rounded-lg mt-4"></div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Actual Content -->
            <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                <div class="p-6 sm:p-8 bg-secondary border border-white/5 shadow-2xl rounded-2xl">
                    <div class="max-w-xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-secondary border border-white/5 shadow-2xl rounded-2xl">
                    <div class="max-w-xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-secondary border border-white/5 shadow-2xl rounded-2xl">
                    <div class="max-w-xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
