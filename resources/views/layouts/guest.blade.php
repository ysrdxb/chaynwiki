<x-master-layout>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 p-4">
        <div class="mb-8 text-center pt-10">
            <a href="/" class="group inline-flex items-center gap-3">
                <div class="relative">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-purple-600 flex items-center justify-center shadow-lg shadow-brand-500/30 group-hover:shadow-brand-500/50 transition-all group-hover:scale-105">
                        <span class="text-white font-bold text-xl">C</span>
                    </div>
                    <div class="absolute -inset-1 bg-gradient-to-br from-brand-500 to-purple-600 rounded-xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                </div>
            </a>
            <h1 class="mt-4 text-2xl font-display font-black text-white tracking-tight">CHAYNWIKI</h1>
        </div>

        <div class="w-full sm:max-w-md bg-[#0A0A14] border border-white/10 shadow-2xl rounded-[32px] p-8 md:p-10 relative overflow-hidden backdrop-blur-xl">
            <!-- Card Glow -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/5 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            
            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>
        
        <div class="mt-8 text-center text-xs text-gray-500 font-mono">
            &copy; {{ date('Y') }} ChaynWiki. All rights reserved.
        </div>
    </div>
</x-master-layout>
