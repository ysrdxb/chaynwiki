<div 
    x-data="{ 
        show: @entangle('isVisible'), 
        playing: @entangle('isPlaying'),
        progress: @entangle('progress'),
        audioCtx: null,
        mainGain: null,
        osc1: null,
        osc2: null,
        osc3: null, // High frequency texture
        narrationMode: 'summary', // 'summary' or 'full'
        
        initAudio() {
            if (this.audioCtx) return;
            this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            this.mainGain = this.audioCtx.createGain();
            this.filter = this.audioCtx.createBiquadFilter();
            
            this.filter.type = 'lowpass';
            this.filter.frequency.value = 1000;
            this.filter.Q.value = 1;

            this.mainGain.connect(this.filter);
            this.filter.connect(this.audioCtx.destination);
            this.mainGain.gain.value = 0.05;
        },

        startPulse() {
            this.initAudio();
            if (this.audioCtx.state === 'suspended') this.audioCtx.resume();
            
            this.osc1 = this.audioCtx.createOscillator();
            this.osc1.type = 'sine';
            this.osc1.frequency.setValueAtTime(60, this.audioCtx.currentTime); 
            
            this.osc2 = this.audioCtx.createOscillator();
            this.osc2.type = 'triangle';
            this.osc2.frequency.setValueAtTime(120, this.audioCtx.currentTime);
            
            this.osc1.connect(this.mainGain);
            this.osc2.connect(this.mainGain);
            
            this.osc1.start();
            this.osc2.start();

            // OSC3: High Frequency Shimmer (Elite Texture)
            this.osc3 = this.audioCtx.createOscillator();
            this.osc3.type = 'sine';
            this.osc3.frequency.setValueAtTime(240, this.audioCtx.currentTime); // E4
            this.osc3.connect(this.mainGain);
            this.osc3.start();
            
            this.filter.frequency.exponentialRampToValueAtTime(300, this.audioCtx.currentTime + 2);
            
            this.narrate();
        },

        stopPulse() {
            if (this.mainGain) {
                // Smooth fade out to prevent the 'tuuuu' sound
                this.mainGain.gain.exponentialRampToValueAtTime(0.0001, this.audioCtx.currentTime + 1.5);
                setTimeout(() => {
                    if (this.osc1) { try { this.osc1.stop(); } catch(e){} this.osc1 = null; }
                    if (this.osc2) { try { this.osc2.stop(); } catch(e){} this.osc2 = null; }
                    if (this.osc3) { try { this.osc3.stop(); } catch(e){} this.osc3 = null; }
                }, 1600);
            }
            window.speechSynthesis.cancel();
        },

        narrate() {
            const sourceId = this.narrationMode === 'summary' ? 'pulse-summary-source' : 'pulse-full-source';
            const text = document.getElementById(sourceId)?.innerText;
            if (!text || text.length < 5) return;

            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            
            // Link audio to narration end
            utterance.onend = () => {
                this.playing = false; // This triggers stopPulse via $watch
            };

            utterance.rate = 0.9;
            utterance.pitch = 0.85; 
            utterance.volume = 1.0;
            
            const voices = window.speechSynthesis.getVoices();
            const preferred = voices.find(v => v.name.includes('Google US English') || v.name.includes('Male') || v.lang === 'en-GB');
            if (preferred) utterance.voice = preferred;

            window.speechSynthesis.speak(utterance);

            // Progress tracking
            utterance.onboundary = (event) => {
                const charIndex = event.charIndex;
                this.progress = (charIndex / text.length) * 100;
            };
        }
    }"
    x-init="
        $watch('playing', value => {
            if (value) startPulse();
            else stopPulse();
        });
        window.addEventListener('play-article', () => {
            setTimeout(() => { if (playing) narrate(); }, 500);
        });
    "
    x-show="show"
    id="pulse-player-container"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] w-full max-w-[900px] px-6 pointer-events-none"
>
    <!-- Narrative Sources -->
    <div id="pulse-summary-source" class="hidden">{{ $summary }}</div>
    <div id="pulse-full-source" class="hidden">{{ $fullContent }}</div>
    <div class="pointer-events-auto relative group">
        {{-- Glassmorphic Body --}}
        <div class="bg-black/40 backdrop-blur-3xl border border-white/10 rounded-full p-3 flex items-center gap-6 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.8)] relative overflow-hidden">
            
            {{-- Dynamic Background Glow --}}
            <div 
                class="absolute inset-x-0 bottom-0 h-1 opacity-50 blur-sm transition-all duration-1000"
                style="background: {{ $currentArticle?->analysis?->ambient_gradient_css ?? 'linear-gradient(90deg, #3b82f6, #8b5cf6)' }};"
            ></div>

            {{-- Article Thumbnail --}}
            <div class="w-14 h-14 rounded-full overflow-hidden border border-white/20 flex-shrink-0 relative group/thumb bg-white/5">
                @if($currentArticle)
                    <img src="{{ $currentArticle->featured_image }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white/20 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/thumb:opacity-100 transition-opacity">
                    <button @click.stop="playing = !playing">
                        <svg x-show="playing" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6zm8 0h4v16h-4z"/></svg>
                        <svg x-show="!playing" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <!-- Narration Toggle -->
                    <div class="absolute -bottom-1 flex gap-1">
                        <button @click.stop="narrationMode = 'summary'; if(playing) narrate()" 
                            class="w-1.5 h-1.5 rounded-full transition-all"
                            :class="narrationMode === 'summary' ? 'bg-blue-500 scale-125' : 'bg-white/20'"></button>
                        <button @click.stop="narrationMode = 'full'; if(playing) narrate()" 
                            class="w-1.5 h-1.5 rounded-full transition-all"
                            :class="narrationMode === 'full' ? 'bg-blue-500 scale-125' : 'bg-white/20'"></button>
                    </div>
                </div>
            </div>

            {{-- Info & Metadata --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <h4 class="text-[11px] font-black text-white italic uppercase tracking-tighter truncate">
                        {{ $currentArticle?->title ?? 'Transmission Active' }}
                    </h4>
                    <span class="px-2 py-0.5 bg-blue-500/10 border border-blue-500/20 rounded text-[7px] font-black text-blue-400 uppercase tracking-widest">
                        LIVE PULSE
                    </span>
                </div>
                <div class="text-[9px] font-black text-white/40 uppercase tracking-[0.2em] mt-1 truncate">
                    @if($currentArticle?->category === 'song')
                        {{ $currentArticle->song->artist->name ?? 'Unknown Artist' }} — {{ $currentArticle->song->album ?? 'Single' }}
                    @else
                        {{ ucfirst($currentArticle?->category ?? 'Registry') }} Node Reference
                    @endif
                </div>
            </div>

            {{-- Spectral Visualizer (Simulated) --}}
            <div class="hidden md:flex items-end gap-1 h-8 px-4 opacity-50">
                @for($i = 0; $i < 12; $i++)
                    <div 
                        class="w-1 bg-white/20 rounded-full" 
                        :class="playing ? 'animate-bounce' : ''"
                        style="height: {{ rand(20, 100) }}%; animation-delay: {{ $i * 100 }}ms; animation-duration: {{ rand(600, 1200) }}ms;"
                    ></div>
                @endfor
            </div>

            {{-- Controls --}}
            <div class="flex items-center gap-4 pr-4 border-l border-white/5 pl-6">
                <button class="text-white/20 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="playing = !playing" class="w-10 h-10 rounded-full bg-white text-black flex items-center justify-center hover:scale-105 transition-all">
                    <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                    <svg x-show="!playing" class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
                <button class="text-white/20 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
                <button wire:click="stop" class="text-white/10 hover:text-red-500/50 transition-colors ml-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Progress Rail --}}
        <div class="absolute -bottom-1 inset-x-12 h-0.5 bg-white/5 rounded-full overflow-hidden">
            <div 
                class="h-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)] transition-all duration-300"
                style="width: {{ $progress }}%"
            ></div>
        </div>
    </div>
</div>
