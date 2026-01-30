<div class="min-h-screen bg-[#050511] pt-32" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 800)">
    {{-- Header --}}
    <div class="relative py-16 border-b border-white/5 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/5 via-transparent to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/5 border border-blue-500/10 text-blue-500 text-[9px] font-black uppercase tracking-[0.2em] mb-6">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Interactive Explorer Node
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                    KNOWLEDGE <span class="text-blue-500">EXPLORER</span>
                </h1>
                <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] max-w-xl mx-auto leading-relaxed">
                    Map the evolution of genres, track artist collaborations, and navigate the global music archive.
                </p>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex justify-center gap-4">
                @foreach(['genres' => 'Genre Map', 'artists' => 'Artist Network', 'timeline' => 'Chronology'] as $tab => $label)
                <button
                    wire:click="setTab('{{ $tab }}')"
                    class="px-6 py-2.5 rounded-xl font-black text-[9px] uppercase tracking-[0.2em] transition-all {{ $activeTab === $tab ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/10' : 'bg-white/5 text-white/20 border border-white/5 hover:border-white/10 hover:text-white' }}"
                >
                    <span class="flex items-center gap-2">
                        @if($tab === 'genres')
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @elseif($tab === 'artists')
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @else
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                        {{ $label }}
                    </span>
                </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Skeleton Loader --}}
    <div x-show="!loaded" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 transition-all duration-500">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1">
                <div class="bg-secondary border border-white/5 rounded-2xl overflow-hidden skeleton-v2" style="height: 600px;"></div>
                <div class="mt-6 flex justify-center gap-4">
                    <div class="w-24 h-2 bg-white/5 rounded-full skeleton-v2"></div>
                    <div class="w-24 h-2 bg-white/5 rounded-full skeleton-v2"></div>
                    <div class="w-24 h-2 bg-white/5 rounded-full skeleton-v2"></div>
                </div>
            </div>
            <div class="w-full lg:w-80 space-y-4">
                <div class="bg-secondary border border-white/5 rounded-2xl p-8 skeleton-v2" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    {{-- Explorer Content --}}
    <div x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1 relative group">
                <div class="bg-secondary border border-white/5 rounded-2xl overflow-hidden shadow-2xl transition-all duration-500 hover:border-blue-500/10" style="min-height: 600px;">
                    <div wire:loading wire:target="setTab" class="absolute inset-0 bg-black/40 backdrop-blur-sm z-20 flex items-center justify-center rounded-3xl">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-10 h-10 border-4 border-blue-500/20 border-t-blue-500 rounded-full animate-spin"></div>
                            <span class="text-xs font-mono text-blue-400 uppercase tracking-widest">Recalculating...</span>
                        </div>
                    </div>
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
            <div class="w-full lg:w-80">
                @if($genreDetails)
                    <div class="bg-secondary border border-white/5 rounded-2xl p-8 sticky top-32 shadow-2xl animate-fade-in">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black text-white uppercase italic tracking-tighter">{{ $genreDetails['genre']['name'] ?? 'Node Detail' }}</h3>
                        <button wire:click="closeDetails" class="text-white/20 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

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
                @else
                    <div class="bg-secondary/40 border border-white/5 border-dashed rounded-2xl p-8 text-center sticky top-32 h-[410px] flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                        </div>
                        <h4 class="text-[11px] font-black text-white uppercase tracking-widest mb-2">Select a Node</h4>
                        <p class="text-[9px] font-black text-white/20 uppercase tracking-widest leading-loose">Interact with the visualization map to access detailed record connections.</p>
                    </div>
                @endif
            </div>
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
