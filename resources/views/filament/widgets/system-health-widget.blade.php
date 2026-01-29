<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-sm font-mono font-bold text-gray-400 uppercase tracking-widest">Global Network Health</h2>
            <div class="flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-xs font-mono text-green-500 font-bold uppercase">All Systems Nominal</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($this->getHealthData()['nodes'] as $node)
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-white/10 transition-all group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-mono text-gray-500 uppercase tracking-tighter">{{ $node['type'] }}</span>
                        <span class="text-[10px] font-mono {{ $node['status'] === 'online' ? 'text-green-500' : 'text-red-500' }} font-black uppercase">
                            {{ $node['status'] }}
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full {{ $node['status'] === 'online' ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]' }}"></div>
                        <h3 class="text-sm font-bold text-white tracking-tight">{{ $node['name'] }}</h3>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-[10px] font-mono text-gray-600">LATENCY</div>
                        <div class="text-[10px] font-mono text-brand-400 font-bold">{{ $node['latency'] }}</div>
                    </div>
                    
                    {{-- Micro Visualization Sparkline --}}
                    <div class="mt-2 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-brand-500/50 rounded-full" style="width: {{ rand(60, 95) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>

    <style>
        .fi-section {
            background-color: rgba(10, 10, 20, 0.4) !important;
            backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 24px !important;
        }
    </style>
</x-filament-widgets::widget>
