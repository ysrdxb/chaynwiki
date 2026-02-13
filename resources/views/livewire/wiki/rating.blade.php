<?php

use Livewire\Component;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $model;
    public $userScore = null;
    public $average = 0;
    public $totalVotes = 0;
    public $distribution = [];

    public function mount($model)
    {
        $this->model = $model;
        $this->refreshStats();
        
        if (Auth::check()) {
            $vote = $this->model->votes()
                ->where('user_id', Auth::id())
                ->first();
            $this->userScore = $vote ? $vote->score : null;
        }
    }

    public function rate($score)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->model->votes()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['value' => 1, 'score' => $score] // Value 1 ensures compatibility with old system if needed
        );

        $this->userScore = $score;
        $this->refreshStats();
    }

    public function refreshStats()
    {
        // Calculate Average & Total
        $this->totalVotes = $this->model->votes()->whereNotNull('score')->count();
        $this->average = $this->totalVotes > 0 
            ? round($this->model->votes()->avg('score'), 1) 
            : 0;

        // Calculate Distribution
        $rawDist = $this->model->votes()
            ->whereNotNull('score')
            ->selectRaw('score, count(*) as count')
            ->groupBy('score')
            ->pluck('count', 'score')
            ->toArray();

        // Fill gaps 1-10
        $this->distribution = [];
        $maxCount = 0;
        for ($i = 1; $i <= 10; $i++) {
            $count = $rawDist[$i] ?? 0;
            $this->distribution[$i] = $count;
            if ($count > $maxCount) $maxCount = $count;
        }

        // Normalize for bar heights (max height 100%)
        foreach ($this->distribution as $key => $val) {
             $this->distribution[$key] = [
                 'count' => $val,
                 'height' => $maxCount > 0 ? ($val / $maxCount) * 100 : 0
             ];
        }
    }
};
?>

<div class="card-premium-unified !bg-[#161b22]/40 !p-8 animate-fade-in-up">
    <div class="flex flex-col md:flex-row gap-12 items-center">
        <!-- Left: Average & User Action -->
        <div class="flex flex-col items-center min-w-[200px] text-center">
             <div class="relative mb-4 group cursor-default">
                 <!-- Average Score Circle -->
                 <div class="w-24 h-24 rounded-full border-4 border-white/5 bg-white/5 flex items-center justify-center relative overflow-hidden">
                     <div class="absolute inset-0 bg-blue-500/20 blur-xl"></div>
                     <span class="text-4xl font-black text-white tracking-tighter relative z-10">{{ $average }}</span>
                 </div>
                 <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full border border-[#0d1117]">
                    AVG
                 </div>
             </div>
             
             <div class="text-[11px] font-bold text-white/40 uppercase tracking-widest mb-6">
                 {{ number_format($totalVotes) }} Ratings
             </div>

             <!-- Rating Input (Stars/Dots) -->
             <div class="flex items-center gap-1 mb-2" x-data="{ hoverScore: 0 }">
                 @for($i = 1; $i <= 10; $i++)
                     <button 
                         wire:click="rate({{ $i }})" 
                         @mouseenter="hoverScore = {{ $i }}" 
                         @mouseleave="hoverScore = 0"
                         class="w-1.5 h-6 rounded-full transition-all duration-200"
                         :class="{
                             'bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)] scale-y-125': hoverScore >= {{ $i }} || (hoverScore === 0 && {{ $userScore ?? 0 }} >= {{ $i }}),
                             'bg-white/10 hover:bg-white/30': !(hoverScore >= {{ $i }} || (hoverScore === 0 && {{ $userScore ?? 0 }} >= {{ $i }}))
                         }"
                     ></button>
                 @endfor
             </div>
             <p class="text-[10px] text-white/30 font-medium">
                 @if($userScore)
                    Your rating: <span class="text-blue-400 font-bold">{{ $userScore }}/10</span>
                 @else
                    Click bars to rate
                 @endif
             </p>
        </div>

        <!-- Right: Histogram -->
        <div class="flex-1 w-full h-[150px] flex items-end gap-2 relative pt-8">
            <!-- Grid Lines -->
            <div class="absolute inset-0 border-b border-white/5 pointer-events-none"></div>
            
            @foreach($distribution as $score => $data)
                <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                    <!-- Tooltip -->
                    <div class="absolute -top-8 opacity-0 group-hover:opacity-100 transition-opacity bg-black/80 text-white text-[10px] font-bold px-2 py-1 rounded border border-white/10 whitespace-nowrap z-10 pointer-events-none">
                        {{ $data['count'] }} votes ({{ $score }})
                    </div>
                    
                    <!-- Bar -->
                    <div class="w-full bg-white/5 rounded-t-sm relative overflow-hidden transition-all duration-500 group-hover:bg-white/10" 
                         style="height: {{ max(5, $data['height']) }}%">
                        <!-- Fill Gradient -->
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-blue-600 to-cyan-400 opacity-60 transition-all duration-500"
                             style="height: 100%"></div>
                         <!-- Highlight if this is user score -->
                         @if($userScore == $score)
                            <div class="absolute inset-0 border-2 border-white/50 rounded-t-sm"></div>
                         @endif
                    </div>
                    
                    <!-- Label -->
                    <span class="text-[9px] font-bold text-white/20 mt-2 group-hover:text-white/60 transition-colors">{{ $score }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>