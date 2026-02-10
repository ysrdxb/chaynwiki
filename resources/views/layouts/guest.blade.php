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
                <a href="/" class="inline-flex items-center gap-3 mb-16">
                    <span class="text-2xl font-black text-white tracking-tightest uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">CHAYN<span class="text-blue-500">WIKI</span></span>
                </a>

                <!-- Welcome Text -->
                <div class="mb-12 relative">
                    <div class="absolute -left-12 -top-12 w-64 h-64 bg-blue-500/5 rounded-full blur-[100px] -z-10"></div>
                    <h1 class="text-[56px] lg:text-[72px] font-black text-white mb-6 leading-[0.85] tracking-tightest uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        WELCOME<br>
                        <span class="text-white/20">BACK NODE</span>
                    </h1>
                    <p class="text-white/30 text-[12px] font-black uppercase tracking-[0.4em] max-w-sm leading-relaxed">
                        Establishing secure connection to the ChaynWiki global archive.
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
        <div class="hidden lg:flex w-[45%] xl:w-[50%] p-12 items-center">
            <div class="relative w-full h-[90vh] rounded-[3rem] overflow-hidden auth-card-shadow bg-[#0d1117] border border-white/5 group">
                <!-- Background Image with Parallax-like effect -->
                <img 
                    src="https://images.unsplash.com/photo-1461784180009-21121b2f204c?w=1200&q=80" 
                    alt="Vinyl Record" 
                    class="absolute inset-0 w-full h-full object-cover opacity-60 grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000"
                    loading="lazy"
                >
                
                <!-- Advanced Overlays -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/40 to-transparent"></div>
                <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/0 transition-colors duration-1000"></div>
                
                <!-- Floating Labels/Content inside card -->
                <div class="absolute bottom-16 left-16 right-16">
                    <div class="flex items-end justify-between gap-6">
                        <div class="flex-1">
                            <span class="px-3 py-1 bg-blue-500 text-[#0d1117] text-[10px] font-black uppercase tracking-[0.3em] inline-block mb-6 shadow-2xl">Verified Access</span>
                            <h2 class="text-4xl font-black text-white uppercase tracking-tightest mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">THE MUSIC HUB</h2>
                            <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.4em]">Synchronizing 1.2M Records</p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-white/5 backdrop-blur-2xl border border-white/10 flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all duration-500">
                             <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>
