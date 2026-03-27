@props(['track1', 'track2'])

<div class="card-premium-unified p-8" x-data="{
    track1: {{ json_encode($track1) }},
    track2: {{ json_encode($track2) }},
    init() {
        this.renderChart();
    },
    renderChart() {
        const ctx = this.$refs.canvas.getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Energy', 'Danceability', 'Valence', 'Acousticness', 'Instrumentalness'],
                datasets: [
                    {
                        label: this.track1.title,
                        data: [
                            this.track1.energy,
                            this.track1.danceability,
                            this.track1.valence,
                            this.track1.acousticness,
                            this.track1.instrumentalness
                        ],
                        backgroundColor: 'rgba(56, 189, 248, 0.2)',
                        borderColor: '#38bdf8',
                        pointBackgroundColor: '#38bdf8',
                        borderWidth: 2
                    },
                    {
                        label: this.track2.title,
                        data: [
                            this.track2.energy,
                            this.track2.danceability,
                            this.track2.valence,
                            this.track2.acousticness,
                            this.track2.instrumentalness
                        ],
                        backgroundColor: 'rgba(236, 72, 153, 0.2)',
                        borderColor: '#ec4899',
                        pointBackgroundColor: '#ec4899',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                scales: {
                    r: {
                        angleLines: { color: 'rgba(255, 255, 255, 0.1)' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        pointLabels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            font: { size: 10, family: 'Inter', weight: 'bold' }
                        },
                        ticks: { display: false, max: 100, min: 0 }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#fff', font: { family: 'Inter', weight: 'bold' } }
                    }
                }
            }
        });
    }
}">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-xl font-black text-white uppercase tracking-tighter">Sonic DNA Comparison</h3>
        <span class="px-2 py-1 bg-white/5 rounded text-[10px] text-white/40 font-bold uppercase tracking-widest">Beta</span>
    </div>
    
    <div class="relative aspect-square max-w-[400px] mx-auto">
        <canvas x-ref="canvas"></canvas>
    </div>
    
    {{-- Key Stats Below --}}
    <div class="grid grid-cols-2 gap-4 mt-8 border-t border-white/5 pt-6">
        <div class="text-center">
            <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest mb-1">{{ $track1['title'] }}</p>
            <p class="text-2xl font-black text-white">{{ $track1['bpm'] }} <span class="text-sm font-medium text-white/40">BPM</span></p>
            <p class="text-xs text-white/50">{{ $track1['key'] }}</p>
        </div>
        <div class="text-center">
             <p class="text-[10px] text-pink-400 font-bold uppercase tracking-widest mb-1">{{ $track2['title'] }}</p>
            <p class="text-2xl font-black text-white">{{ $track2['bpm'] }} <span class="text-sm font-medium text-white/40">BPM</span></p>
            <p class="text-xs text-white/50">{{ $track2['key'] }}</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
