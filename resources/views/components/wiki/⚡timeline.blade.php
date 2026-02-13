<?php

use Livewire\Volt\Component;
use App\Models\Milestone;
use Illuminate\Database\Eloquent\Model;

new class extends Component
{
    public $entity;
    public $activeType = 'all';

    public function with()
    {
        $query = $this->entity->milestones()->orderBy('event_date');
        
        if ($this->activeType !== 'all') {
            $query->where('type', $this->activeType);
        }

        $milestones = $query->get()->map(function($m) {
            return [
                'id' => $m->id,
                'content' => $m->title,
                'start' => $m->event_date->format('Y-m-d'),
                'className' => "milestone-type-{$m->type}",
                'title' => $m->description,
                'type' => $m->type
            ];
        });

        // Add automated releases if entity is Artist
        if ($this->entity instanceof \App\Models\Artist && $this->activeType === 'all' || $this->activeType === 'release') {
            $releases = $this->entity->songs()
                ->whereNotNull('release_date')
                ->get()
                ->map(function($s) {
                    return [
                        'id' => "song-{$s->id}",
                        'content' => "💿 " . $s->title,
                        'start' => $s->release_date->format('Y-m-d'),
                        'className' => 'milestone-type-release',
                        'title' => "Official Release: {$s->title}",
                        'type' => 'release'
                    ];
                });
            $milestones = $milestones->concat($releases);
        }

        return [
            'timelineData' => $milestones
        ];
    }

    public function filterType($type)
    {
        $this->activeType = $type;
    }
};
?>

<div class="bg-secondary/40 border border-white/5 rounded-[32px] p-8 lg:p-12 overflow-hidden shadow-2xl relative" x-data="{ 
    initTimeline() {
        const container = this.$refs.timelineContainer;
        const items = new vis.DataSet(@js($timelineData));
        
        const options = {
            style: 'box',
            horizontalScroll: true,
            zoomKey: 'ctrlKey',
            margin: { item: 20 },
            orientation: 'top',
            showCurrentTime: false,
            template: function(item) {
                let icon = '';
                switch(item.type) {
                    case 'release': icon = '💿'; break;
                    case 'award': icon = '🏆'; break;
                    case 'event': icon = '🏟️'; break;
                    default: icon = '📍';
                }
                return `
                    <div class='flex items-center gap-3 px-2 py-1'>
                        <span class='text-lg'>${icon}</span>
                        <div class='flex flex-col'>
                            <span class='text-[13px] font-black text-white leading-none mb-1 uppercase tracking-tight'>${item.content}</span>
                            <span class='text-[10px] font-black text-white/40 uppercase tracking-widest'>${item.start}</span>
                        </div>
                    </div>
                `;
            }
        };

        if (window.entityTimeline) {
            window.entityTimeline.destroy();
        }
        window.entityTimeline = new vis.Timeline(container, items, options);
    }
}" x-init="initTimeline()" @timeline-refresh.window="initTimeline()">
    
    {{-- Header Controls --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-12">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-2">Chronicle & Milestones</h3>
            <p class="text-[11px] font-black text-white/20 uppercase tracking-[0.3em]">Temporal mapping of key archival events</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @foreach(['all' => 'Overview', 'release' => 'Releases', 'award' => 'Awards', 'event' => 'Events', 'milestone' => 'History'] as $key => $label)
                <button wire:click="filterType('{{ $key }}')" 
                    class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $activeType === $key ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/20' : 'bg-white/5 text-white/40 hover:text-white hover:bg-white/10' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Timeline Viz --}}
    <div wire:ignore class="h-[300px] w-full relative" id="entity-timeline-container">
        <div x-ref="timelineContainer" class="absolute inset-0"></div>
    </div>

    {{-- Legend --}}
    <div class="mt-12 pt-8 border-t border-white/5 flex flex-wrap gap-8 items-center justify-center">
        <div class="flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            <span class="text-[10px] font-black text-white/30 uppercase tracking-widest">Interactive Plot</span>
        </div>
        <div class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">
            Hold <kbd class="px-2 py-1 bg-white/5 border border-white/10 rounded">CTRL</kbd> + Scroll to Zoom
        </div>
    </div>

    <style>
        .vis-timeline { border: none !important; background: transparent !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .vis-item { background: rgba(255, 255, 255, 0.03) !important; border: 1px solid rgba(255, 255, 255, 0.08) !important; border-radius: 12px !important; transition: all 0.3s ease !important; cursor: pointer !important; }
        .vis-item:hover { background: rgba(59, 130, 246, 0.1) !important; border-color: rgba(59, 130, 246, 0.3) !important; transform: translateY(-2px); }
        .vis-item.vis-selected { background: rgba(59, 130, 246, 0.2) !important; border-color: #3b82f6 !important; }
        .vis-time-axis .vis-text { color: rgba(255, 255, 255, 0.2) !important; font-size: 10px !important; font-weight: 800 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; }
        .vis-time-axis .vis-grid.vis-minor { border-color: rgba(255, 255, 255, 0.03) !important; }
        .vis-time-axis .vis-grid.vis-major { border-color: rgba(255, 255, 255, 0.08) !important; }
        .vis-custom-time { background-color: #3b82f6 !important; }
    </style>
</div>