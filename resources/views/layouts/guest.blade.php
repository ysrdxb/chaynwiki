<x-master-layout>
    <div class="min-h-screen flex" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 600)">
        <!-- Left Panel - Form -->
        <div class="flex-1 flex flex-col justify-center px-8 md:px-16 lg:px-24 py-12 bg-[#050511]">
            <div class="max-w-md w-full mx-auto">
                <!-- Logo -->
                <a href="/" class="inline-flex items-center gap-3 mb-12">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">C</span>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">CHAYNWIKI</span>
                </a>

                <!-- Welcome Text -->
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 leading-tight">
                    WELCOME BACK<br>
                    <span class="text-blue-500">TO CHAYNWIKI</span>
                </h1>
                <p class="text-gray-400 mb-10">
                    Your gateway to contributing and exploring the world of music knowledge.
                </p>

                <!-- Skeleton Loading State -->
                <div x-show="!loaded" class="space-y-6">
                    <!-- Form Skeleton -->
                    <div class="space-y-5">
                        <!-- Input Skeleton 1 -->
                        <div>
                            <div class="skeleton-v2 h-4 w-16 mb-2" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 6px;"></div>
                            <div class="skeleton-v2 h-14 w-full rounded-xl" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 12px;"></div>
                        </div>
                        <!-- Input Skeleton 2 -->
                        <div>
                            <div class="skeleton-v2 h-4 w-20 mb-2" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 6px;"></div>
                            <div class="skeleton-v2 h-14 w-full rounded-xl" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 12px;"></div>
                        </div>
                        <!-- Checkbox Skeleton -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="skeleton-v2 w-4 h-4 rounded" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite;"></div>
                                <div class="skeleton-v2 h-4 w-24" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 6px;"></div>
                            </div>
                            <div class="skeleton-v2 h-4 w-28" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 6px;"></div>
                        </div>
                        <!-- Button Skeleton -->
                        <div class="skeleton-v2 h-14 w-full rounded-full" style="background: linear-gradient(90deg, rgba(59,130,246,0.1) 0%, rgba(59,130,246,0.2) 50%, rgba(59,130,246,0.1) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 50px;"></div>
                    </div>
                    <!-- Link Skeleton -->
                    <div class="flex justify-center mt-8">
                        <div class="skeleton-v2 h-4 w-48" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 6px;"></div>
                    </div>
                </div>

                <!-- Actual Form Slot -->
                <div x-show="loaded" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Right Panel - Decorative Image -->
        <div class="hidden lg:block w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0A0F20] to-[#050511]"></div>
            <!-- Vinyl Record Image -->
            <img 
                src="https://images.unsplash.com/photo-1461784180009-21121b2f204c?w=1200&q=80" 
                alt="Vinyl Record" 
                class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-luminosity"
                loading="lazy"
            >
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#050511] via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#050511] via-transparent to-transparent"></div>
            
            <!-- Floating Stats -->
            <div class="absolute bottom-16 left-16 right-16 space-y-4">
                <div class="flex items-center gap-4" x-show="loaded" x-transition.delay.200ms>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">10,000+</div>
                        <div class="text-sm text-gray-400">Music Articles</div>
                    </div>
                </div>
                <div class="flex items-center gap-4" x-show="loaded" x-transition.delay.400ms>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">5,000+</div>
                        <div class="text-sm text-gray-400">Contributors</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('styles')
    <style>
        @keyframes skeleton-shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    @endpush
</x-master-layout>
