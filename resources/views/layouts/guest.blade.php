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
                <a href="/" class="inline-flex items-center gap-3 mb-12">
                    <span class="text-2xl font-black text-white tracking-tighter">CHAYNWIKI</span>
                </a>

                <!-- Welcome Text -->
                <div class="mb-10">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-[1.05] tracking-tighter uppercase whitespace-normal">
                        WELCOME BACK<br>
                        TO CHAYNWIKI
                    </h1>
                    <p class="text-white/40 text-lg leading-relaxed font-medium max-w-sm">
                        Your gateway to contributing and exploring the world of music knowledge.
                    </p>
                </div>

                <!-- Actual Form Slot -->
                <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    {{ $slot }}
                </div>
                
                <!-- Skeleton Loading State -->
                <div x-show="!loaded" class="space-y-6">
                    <div class="skeleton-v2 h-10 w-48 bg-white/5 rounded-lg border border-white/5"></div>
                    <div class="space-y-4">
                        <div class="skeleton-v2 h-14 w-full bg-white/5 rounded-2xl border border-white/5"></div>
                        <div class="skeleton-v2 h-14 w-full bg-white/5 rounded-2xl border border-white/5"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Decorative Card -->
        <div class="hidden lg:flex w-[45%] xl:w-[50%] p-8 items-center">
            <div class="relative w-full h-full rounded-[40px] overflow-hidden auth-card-shadow bg-[#161b22]">
                <!-- Background Image -->
                <img 
                    src="https://images.unsplash.com/photo-1461784180009-21121b2f204c?w=1200&q=80" 
                    alt="Vinyl Record" 
                    class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay"
                    loading="lazy"
                >
                
                <!-- Gradient Overlays -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
                
                <!-- Floating Labels/Content inside card if needed -->
                <div class="absolute bottom-12 left-12 right-12">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-xl">The Music Hub</p>
                            <p class="text-white/40 text-sm font-medium tracking-wide">Join thousands of contributors</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>
