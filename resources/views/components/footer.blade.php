<footer class="relative bg-[#0d1117] border-t border-white/5 overflow-hidden">
    <div class="relative max-w-[1400px] mx-auto px-8 pt-32 pb-24 flex flex-col items-center">
        {{-- Giant Brand Name - Centered --}}
        <h2 class="w-full text-[100px] sm:text-[140px] md:text-[180px] lg:text-[220px] font-black text-white uppercase leading-none mb-16 select-none text-center tracking-[-0.05em]" 
            style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 900;">
            CHAYNWIKI
        </h2>

        {{-- Navigation Links --}}
        <nav class="flex flex-wrap justify-center gap-x-12 gap-y-4 mb-16">
            <a href="{{ route('home') }}" class="text-white/40 hover:text-white text-[14px] font-bold uppercase tracking-widest transition-colors">Home</a>
            <a href="{{ route('wiki.index') }}" class="text-white/40 hover:text-white text-[14px] font-bold uppercase tracking-widest transition-colors">Wiki</a>
            <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="text-white/40 hover:text-white text-[14px] font-bold uppercase tracking-widest transition-colors">Artists</a>
            <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="text-white/40 hover:text-white text-[14px] font-bold uppercase tracking-widest transition-colors">Genres</a>
            <a href="{{ route('login') }}" class="text-white/40 hover:text-white text-[14px] font-bold uppercase tracking-widest transition-colors">Log in</a>
        </nav>

        {{-- Copyright --}}
        <div class="text-center">
            <p class="text-white/20 text-[13px] font-medium" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                ChaynWiki - All rights reserved.
            </p>
        </div>
    </div>
</footer>
