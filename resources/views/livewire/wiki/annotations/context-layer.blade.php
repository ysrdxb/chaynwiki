<?php

use Livewire\Component;
use App\Models\Annotation;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $articleId;
    public $contextType = 'lyrics'; // or 'bio'
    public $annotations = [];
    
    public $selectedQuote = '';
    public $newAnnotationContent = '';
    
    public $activeAnnotation = null; // For viewing
    public $isCreating = false;

    public function mount($articleId, $contextType = 'lyrics')
    {
        $this->articleId = $articleId;
        $this->contextType = $contextType;
        $this->loadAnnotations();
    }

    public function loadAnnotations()
    {
        $this->annotations = Annotation::where('article_id', $this->articleId)
            ->where('context_type', $this->contextType)
            ->with('user')
            ->get()
            ->toArray();
    }

    public function saveAnnotation($quote, $content)
    {
        if (!Auth::check()) return redirect()->route('login');

        Annotation::create([
            'user_id' => Auth::id(),
            'article_id' => $this->articleId,
            'highlighted_text' => $quote,
            'content' => $content,
            'context_type' => $this->contextType,
        ]);

        $this->loadAnnotations();
        $this->reset('selectedQuote', 'newAnnotationContent', 'isCreating');
        $this->dispatch('annotation-saved'); // Tell Alpine to re-highlight
    }
};
?>

<div 
    x-data="{
        annotations: @entangle('annotations'),
        showSidebar: false,
        sidebarMode: 'view', // 'view' or 'create'
        selectedText: '',
        top: 0,
        left: 0,
        tempAnnotation: null,
        
        init() {
            this.highlightContent();
            $wire.on('annotation-saved', () => {
                this.showSidebar = false;
                this.highlightContent();
            });
        },

        highlightContent() {
            // Simple string matching highlight (MVP)
            // In a real generic implementation, we'd use Range offsets
            const container = document.getElementById('annotatable-content');
            if (!container) return;

            // Strip existing highlights to re-apply
            // Note: This is destructive to event listeners if not careful. 
            // Better to only run once or use more robust DOM manipulation.
            // For MVP, we assume static text content.
            
            // Re-fetching original text might be needed if we constantly re-render.
            // Let's assume the container has the raw text.
            // Actually, manipulating innerHTML is risky with Livewire.
            // We'll rely on a pure JS overlay or just coloring known strings.
        },

        handleSelection() {
            const selection = window.getSelection();
            const text = selection.toString().trim();
            
            if (text.length > 0) {
                const range = selection.getRangeAt(0);
                const rect = range.getBoundingClientRect();
                
                this.selectedText = text;
                // Calculate position relative to viewport or container
                this.top = rect.top + window.scrollY - 40; 
                this.left = rect.left + (rect.width / 2) - 30;
                this.showTooltip = true;
            } else {
                this.showTooltip = false;
            }
        },

        startAnnotation() {
            this.showSidebar = true;
            this.sidebarMode = 'create';
            this.showTooltip = false;
            $wire.set('selectedQuote', this.selectedText);
        },
        
        viewAnnotation(annotation) {
             this.tempAnnotation = annotation;
             this.showSidebar = true;
             this.sidebarMode = 'view';
        }
    }"
    @mouseup.document="handleSelection()"
    class="relative"
>
    <!-- Tooltip Button for Selection -->
    <div 
        x-show="showTooltip" 
        x-transition
        @click.stop="startAnnotation()"
        :style="`top: ${top}px; left: ${left}px`"
        class="fixed z-50 bg-black text-white px-3 py-1.5 rounded-full shadow-xl border border-white/20 cursor-pointer hover:bg-blue-600 transition-colors flex items-center gap-2"
        style="display: none;"
    >
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span class="text-xs font-bold">Annotate</span>
    </div>

    <!-- Content Slot -->
    <div class="relative">
        {{ $slot }}
    </div>

    <!-- The Text Content Wrapper -->
    <!-- We expect the parent view to place the content inside a div with id='annotatable-content' -->
    <script>
        document.addEventListener('livewire:initialized', () => {
             const componentElement = document.querySelector('[wire\\:id="{{ $this->getId() }}"]');
             if (!componentElement) return;
             
             const highlight = () => {
                 // Scoped selection
                 const container = componentElement.querySelector('.annotatable-content');
                 if (!container) return;
                 
                 let html = container.innerHTML;
                 let annotations = @json($annotations);
                 
                 annotations.sort((a, b) => b.highlighted_text.length - a.highlighted_text.length);
                 
                 annotations.forEach(ann => {
                     const text = ann.highlighted_text;
                     const safeText = text.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                     const regex = new RegExp(`(${safeText})`, 'gi');
                     
                     // Check if not already highlighted (simple check)
                     // Note: This check is fragile if innerHTML changes structure, but ok for MVP
                     const replacement = `<span class="bg-yellow-500/20 border-b border-yellow-500/50 cursor-pointer hover:bg-yellow-500/30 transition-colors z-10 annotation-mark" @click.stop="viewAnnotation(annotations.find(a => a.id === ${ann.id}))">$1</span>`;
                     
                     // Only replace if not inside a tag (naive) and not already wrapped
                     // To avoid re-wrapping, we can check if the text is inside a .annotation-mark
                     // A simple way is to strip existing marks first? No, let's just do the replace.
                     // The regex matching plain text might match inside the onclick attribute if we are not careful.
                     
                     html = html.replace(regex, replacement);
                 });
                 
                 container.innerHTML = html;
             };

             // Run on filtered set of actions
             highlight();
             
             Livewire.on('annotation-saved', () => setTimeout(highlight, 100));
        });
    </script>

    <!-- Sidebar / Drawer -->
    <div 
        x-show="showSidebar" 
        x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 w-[400px] bg-[#0d1117] border-l border-white/10 shadow-2xl z-[100] p-8 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-black text-white/50 uppercase tracking-widest">
                <span x-text="sidebarMode === 'create' ? 'Add Annotation' : 'Genius Context'"></span>
            </h3>
            <button @click="showSidebar = false" class="text-white/30 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <template x-if="sidebarMode === 'create'">
            <div class="space-y-6">
                <div class="bg-white/5 p-4 rounded-xl border-l-2 border-blue-500">
                    <p class="text-white/60 italic text-sm">"<span x-text="selectedText"></span>"</p>
                </div>
                
                <textarea 
                    wire:model="newAnnotationContent"
                    class="w-full h-40 bg-[#161b22] border border-white/10 rounded-xl p-4 text-white text-sm focus:border-blue-500 focus:ring-0 transition-all placeholder:text-white/20"
                    placeholder="Provide context, facts, or analysis..."
                ></textarea>
                
                <button 
                    wire:click="saveAnnotation(selectedText, newAnnotationContent)"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition-all"
                >
                    Publish Annotation
                </button>
            </div>
        </template>
        
        <template x-if="sidebarMode === 'view' && tempAnnotation">
            <div class="space-y-6 animate-fade-in">
                <div class="bg-white/5 p-4 rounded-xl border-l-2 border-yellow-500">
                     <p class="text-white/60 italic text-sm">"<span x-text="tempAnnotation.highlighted_text"></span>"</p>
                </div>
                
                <div class="prose prose-invert prose-sm">
                    <p class="text-white leading-relaxed" x-text="tempAnnotation.content"></p>
                </div>
                
                <div class="flex items-center gap-3 pt-6 border-t border-white/5">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                        <span class="text-xs font-bold text-white uppercase" x-text="tempAnnotation.user ? tempAnnotation.user.name.substring(0,1) : '?'"></span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white" x-text="tempAnnotation.user ? tempAnnotation.user.name : 'Unknown'"></p>
                        <p class="text-[10px] text-white/40 uppercase tracking-widest">Contributor</p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>