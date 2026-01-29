<x-app-layout>
    <div class="pt-32 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-8">
                <h1 class="text-4xl font-display font-black text-white uppercase tracking-tight">Settings</h1>
                <p class="text-gray-400">Manage your account and preferences.</p>
            </div>

            <div class="p-4 sm:p-8 bg-[#0A0A14] border border-white/10 shadow-xl sm:rounded-3xl">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#0A0A14] border border-white/10 shadow-xl sm:rounded-3xl">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#0A0A14] border border-white/10 shadow-xl sm:rounded-3xl">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
