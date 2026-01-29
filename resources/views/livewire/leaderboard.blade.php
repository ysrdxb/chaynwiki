<div class="min-h-screen bg-[#050511] py-12 pt-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-mono uppercase tracking-widest mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                Top Contributors
            </div>
            <h1 class="text-4xl md:text-5xl font-display font-black text-white uppercase tracking-tight mb-4">
                Leaderboard
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto">
                Our most active contributors building the ultimate music knowledge base.
            </p>
        </div>

        {{-- Top 3 Podium --}}
        @if(count($leaderboard) >= 3)
            <div class="grid grid-cols-3 gap-4 mb-12">
                {{-- 2nd Place --}}
                <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6 text-center order-1">
                    <div class="w-16 h-16 rounded-full bg-gray-400/20 flex items-center justify-center mx-auto mb-4 text-2xl">
                        🥈
                    </div>
                    <div class="text-lg font-bold text-white mb-1">{{ $leaderboard[1]['name'] ?? 'Anonymous' }}</div>
                    <div class="text-yellow-400 font-mono text-lg">{{ number_format($leaderboard[1]['points'] ?? 0) }} pts</div>
                    <div class="text-gray-500 text-xs mt-2">{{ $leaderboard[1]['articles_count'] ?? 0 }} articles</div>
                </div>

                {{-- 1st Place --}}
                <div class="bg-gradient-to-b from-yellow-500/10 to-[#0A0A14] border border-yellow-500/30 rounded-2xl p-6 text-center order-0 -mt-4">
                    <div class="w-20 h-20 rounded-full bg-yellow-500/20 flex items-center justify-center mx-auto mb-4 text-3xl animate-pulse">
                        👑
                    </div>
                    <div class="text-xl font-bold text-white mb-1">{{ $leaderboard[0]['name'] ?? 'Anonymous' }}</div>
                    <div class="text-yellow-400 font-mono text-xl">{{ number_format($leaderboard[0]['points'] ?? 0) }} pts</div>
                    <div class="text-gray-500 text-xs mt-2">{{ $leaderboard[0]['articles_count'] ?? 0 }} articles</div>
                </div>

                {{-- 3rd Place --}}
                <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6 text-center order-2">
                    <div class="w-16 h-16 rounded-full bg-amber-700/20 flex items-center justify-center mx-auto mb-4 text-2xl">
                        🥉
                    </div>
                    <div class="text-lg font-bold text-white mb-1">{{ $leaderboard[2]['name'] ?? 'Anonymous' }}</div>
                    <div class="text-yellow-400 font-mono text-lg">{{ number_format($leaderboard[2]['points'] ?? 0) }} pts</div>
                    <div class="text-gray-500 text-xs mt-2">{{ $leaderboard[2]['articles_count'] ?? 0 }} articles</div>
                </div>
            </div>
        @endif

        {{-- Full Leaderboard Table --}}
        <div class="bg-[#0A0A14] border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between">
                <h2 class="text-lg font-bold text-white">All Rankings</h2>
            </div>

            <div class="divide-y divide-white/5">
                @forelse($leaderboard as $index => $user)
                    <div class="px-6 py-4 flex items-center gap-4 {{ $index < 3 ? 'bg-yellow-500/5' : '' }}">
                        {{-- Rank --}}
                        <div class="w-8 text-center font-mono font-bold {{ $index < 3 ? 'text-yellow-400' : 'text-gray-500' }}">
                            {{ $index + 1 }}
                        </div>

                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-400 font-bold">
                            {{ strtoupper(substr($user['name'] ?? 'A', 0, 1)) }}
                        </div>

                        {{-- Name --}}
                        <div class="flex-1">
                            <div class="text-white font-semibold">{{ $user['name'] ?? 'Anonymous' }}</div>
                            <div class="text-gray-500 text-xs">
                                {{ $user['articles_count'] ?? 0 }} articles · {{ $user['achievements_count'] ?? 0 }} badges
                            </div>
                        </div>

                        {{-- Points --}}
                        <div class="text-right">
                            <div class="text-yellow-400 font-mono font-bold">{{ number_format($user['points'] ?? 0) }}</div>
                            <div class="text-gray-500 text-xs">points</div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        No contributors yet. Be the first!
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="text-center mt-12">
            <p class="text-gray-400 mb-4">Want to climb the ranks?</p>
            <a href="{{ route('wiki.create') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl transition-all">
                <span>Start Contributing</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
