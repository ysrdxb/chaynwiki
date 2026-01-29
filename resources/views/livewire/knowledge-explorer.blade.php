<div class="min-h-screen bg-[#050511] pt-32">
    {{-- Header --}}
    <div class="bg-gradient-to-b from-purple-900/20 to-transparent py-12 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-500/20 text-purple-400 text-xs font-mono uppercase tracking-widest mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Interactive Explorer
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-black text-white uppercase tracking-tight mb-4">
                    Knowledge Explorer
                </h1>
                <p class="text-gray-400 max-w-xl mx-auto">
                    Discover how genres evolved, explore artist collaborations, and navigate music history.
                </p>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex justify-center gap-4">
                <button
                    wire:click="setTab('genres')"
                    class="px-6 py-3 rounded-xl font-semibold transition-all {{ $activeTab === 'genres' ? 'bg-purple-600 text-white' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10' }}"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Genre Map
                    </span>
                </button>
                <button
                    wire:click="setTab('artists')"
                    class="px-6 py-3 rounded-xl font-semibold transition-all {{ $activeTab === 'artists' ? 'bg-purple-600 text-white' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10' }}"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Artist Network
                    </span>
                </button>
                <button
                    wire:click="setTab('timeline')"
                    class="px-6 py-3 rounded-xl font-semibold transition-all {{ $activeTab === 'timeline' ? 'bg-purple-600 text-white' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10' }}"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Timeline
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- Explorer Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            {{-- Main Graph Area --}}
            <div class="flex-1">
                <div class="bg-[#0A0A14] border border-white/10 rounded-2xl overflow-hidden" style="min-height: 600px;">
                    @if($activeTab === 'genres')
                        {{-- Genre Network --}}
                        <div id="genre-network" class="w-full h-[600px]" wire:ignore></div>
                    @elseif($activeTab === 'artists')
                        {{-- Artist Network --}}
                        <div id="artist-network" class="w-full h-[600px]" wire:ignore></div>
                    @elseif($activeTab === 'timeline')
                        {{-- Timeline --}}
                        <div id="music-timeline" class="w-full h-[600px]" wire:ignore></div>
                    @endif
                </div>

                {{-- Legend --}}
                <div class="mt-4 flex flex-wrap gap-4 justify-center text-sm text-gray-400">
                    @if($activeTab === 'genres')
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span>Influences</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                            <span>Derived From</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                            <span>Fusion</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Side Panel (Genre Details) --}}
            @if($genreDetails)
                <div class="w-80 bg-[#0A0A14] border border-white/10 rounded-2xl p-6 self-start">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white">{{ $genreDetails['genre']['name'] ?? 'Genre' }}</h3>
                        <button wire:click="closeDetails" class="text-gray-500 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    @if(!empty($genreDetails['genre']['description']))
                        <p class="text-gray-400 text-sm mb-4">{{ $genreDetails['genre']['description'] }}</p>
                    @endif

                    @if(!empty($genreDetails['genre']['era_start']))
                        <div class="text-xs text-gray-500 mb-4">
                            Era: {{ $genreDetails['genre']['era_start'] }} - {{ $genreDetails['genre']['era_end'] ?? 'Present' }}
                        </div>
                    @endif

                    {{-- Influenced By --}}
                    @if(!empty($genreDetails['influenced_by']))
                        <div class="mb-4">
                            <div class="text-xs font-mono uppercase text-gray-500 mb-2">Influenced By</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($genreDetails['influenced_by'] as $genre)
                                    <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded text-xs">{{ $genre['name'] ?? 'Unknown' }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Influences --}}
                    @if(!empty($genreDetails['influences']))
                        <div class="mb-4">
                            <div class="text-xs font-mono uppercase text-gray-500 mb-2">Influenced</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($genreDetails['influences'] as $genre)
                                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded text-xs">{{ $genre['name'] ?? 'Unknown' }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Related Articles --}}
                    @if(!empty($genreDetails['articles']))
                        <div>
                            <div class="text-xs font-mono uppercase text-gray-500 mb-2">Related Articles</div>
                            <div class="space-y-2">
                                @foreach(array_slice($genreDetails['articles'], 0, 5) as $article)
                                    <a href="{{ route('wiki.show', ['article' => $article['slug']]) }}" class="block text-sm text-gray-300 hover:text-purple-400 truncate">
                                        {{ $article['title'] ?? 'Untitled' }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Vis.js Script --}}
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/vis-timeline/styles/vis-timeline-graph2d.min.css">
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <script src="https://unpkg.com/vis-timeline/standalone/umd/vis-timeline-graph2d.min.js"></script>
    <script>
        document.addEventListener('livewire:navigated', initNetworks);
        document.addEventListener('DOMContentLoaded', initNetworks);

        function initNetworks() {
            const genreData = @json($genreNetwork);
            const artistData = @json($artistNetwork);
            const timelineData = @json($timeline);

            // Genre Network
            const genreContainer = document.getElementById('genre-network');
            if (genreContainer && genreData.nodes.length > 0) {
                const genreNetwork = new vis.Network(genreContainer, {
                    nodes: new vis.DataSet(genreData.nodes),
                    edges: new vis.DataSet(genreData.edges)
                }, {
                    nodes: { shape: 'dot', font: { color: '#fff', size: 14 } },
                    edges: { smooth: { type: 'continuous' } },
                    physics: { stabilization: { iterations: 100 } },
                    interaction: { hover: true }
                });

                genreNetwork.on('click', function(params) {
                    if (params.nodes.length > 0) {
                        @this.selectGenre(params.nodes[0]);
                    }
                });
            }

            // Artist Network
            const artistContainer = document.getElementById('artist-network');
            if (artistContainer && artistData.nodes.length > 0) {
                new vis.Network(artistContainer, {
                    nodes: new vis.DataSet(artistData.nodes),
                    edges: new vis.DataSet(artistData.edges)
                }, {
                    nodes: { shape: 'dot', font: { color: '#fff', size: 12 } },
                    edges: { smooth: true },
                    physics: { stabilization: { iterations: 150 } }
                });
            }

            // Timeline
            const timelineContainer = document.getElementById('music-timeline');
            if (timelineContainer && timelineData.length > 0) {
                const groups = new vis.DataSet([
                    {id: 1, content: 'Music Genres'}
                ]);
                
                const items = timelineData.map(item => ({
                    ...item,
                    group: 1
                }));

                new vis.Timeline(timelineContainer, new vis.DataSet(items), {
                    style: 'modern',
                    zoomMin: 1000 * 60 * 60 * 24 * 31 * 12, // One year
                    margin: { item: 10 }
                });
            }
        }
    </script>
    @endpush
</div>
