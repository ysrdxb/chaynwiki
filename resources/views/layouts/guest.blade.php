<x-master-layout>
    <div class="min-h-screen flex bg-[#0d1117] font-['Inter',sans-serif]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 300)">
        @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <style>
            @keyframes skeleton-shimmer {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }
            .auth-card-shadow {
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            }
        </style>
        @endpush

        <!-- Left Panel - Form -->
        <div class="flex-1 flex flex-col justify-center px-8 md:px-16 lg:px-24 py-12">
            <div class="max-w-md w-full mx-auto">
                <!-- Logo -->
                <a href="/" class="inline-flex items-center gap-3 mb-24">
                    <span class="text-[24px] font-black text-white tracking-tight uppercase" style="font-family: 'MODERNIZ', sans-serif;">CHAYNWIKI</span>
                </a>

                <!-- Welcome Text -->
                <div class="mb-16 relative">
                    <h1 class="text-[48px] md:text-[52px] font-black text-white mb-6 leading-tight tracking-tight uppercase" style="font-family: 'MODERNIZ', sans-serif;">
                        WELCOME BACK<br>TO CHAYNWIKI
                    </h1>
                    <p class="text-white/60 text-[14px] md:text-[16px] font-medium leading-relaxed max-w-sm">
                        Your gateway to contributing and exploring the world of music knowledge.
                    </p>
                </div>

                <!-- Actual Form Slot -->
                <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Right Panel - Decorative Card -->
        <div class="hidden lg:flex w-[45%] xl:w-[50%] p-10 items-center">
            <div class="relative w-full h-[90vh] rounded-[48px] overflow-hidden bg-[#0d1117] border border-white/5">
                <img 
                    src="https://images.unsplash.com/photo-1461784180009-21121b2f204c?w=1200&q=80" 
                    alt="Vinyl Record" 
                    class="absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
        </div>
    </div>
</x-master-layout>
