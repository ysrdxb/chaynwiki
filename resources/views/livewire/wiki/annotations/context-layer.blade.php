<div 
    x-data="{
        showTooltip: false,
        tooltipX: 0,
        tooltipY: 0,
        selection: null,
        isAnnotating: false,
        annotationContent: '',
        
        handleSelection() {
            const selection = window.getSelection();
            if (!selection.rangeCount || selection.isCollapsed) {
                this.showTooltip = false;
                return;
            }
            
            const range = selection.getRangeAt(0);
            const rect = range.getBoundingClientRect();
            const wrapperRect = this.$refs.wrapper.getBoundingClientRect();
            
            // Validate selection is within our wrapper
            if (!this.$refs.wrapper.contains(range.commonAncestorContainer)) return;

            this.selection = {
                text: selection.toString(),
                start: this.getOffset(range.startContainer, range.startOffset),
                end: this.getOffset(range.endContainer, range.endOffset)
            };
            
            this.tooltipX = rect.left + (rect.width / 2) - wrapperRect.left; // Relative X
            this.tooltipY = rect.top - wrapperRect.top - 40; // Relative Y
            this.showTooltip = true;
        },

        getOffset(node, offset) {
            // Simplified offset calculation relative to wrapper content
            // Assuming simplified DOM structure for now
            return offset; // Placeholder logic
        },

        startAnnotating() {
            this.isAnnotating = true;
            this.showTooltip = false;
        },

        submitAnnotation() {
            if (!this.annotationContent) return;
            @this.call('saveAnnotation', {
                text: this.selection.text,
                start: this.selection.start, 
                end: this.selection.end,
                content: this.annotationContent
            });
            this.isAnnotating = false;
            this.annotationContent = '';
            window.getSelection().removeAllRanges();
        }
    }"
    class="relative group"
    x-ref="wrapper"
    @mouseup="handleSelection"
>
    <!-- Content Slot -->
    <div class="relative z-0">
        {{ $slot }}
    </div>

    <!-- Floating Tooltip -->
    <div x-show="showTooltip" 
         x-transition
         class="absolute bg-black text-white px-3 py-1 rounded shadow-lg z-50 cursor-pointer transform -translate-x-1/2 text-xs font-bold uppercase tracking-wider flex items-center gap-2 border border-white/20"
         :style="`left: ${tooltipX}px; top: ${tooltipY}px;`"
         @click="startAnnotating">
        <span>🖊️ Annotate</span>
    </div>

    <!-- Annotation Input Modal -->
    <div x-show="isAnnotating" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm"
         x-transition.opacity>
        <div class="bg-[#161b22] border border-white/10 p-6 rounded-2xl w-full max-w-lg shadow-2xl space-y-4" @click.away="isAnnotating = false">
            <h3 class="text-white font-bold text-lg">Add Interpretation</h3>
            <p class="text-white/50 text-sm italic border-l-2 border-white/20 pl-3 py-1" x-text="'&quot;' + (selection?.text || '') + '&quot;'"></p>
            <textarea x-model="annotationContent" rows="4" class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white placeholder-white/20 focus:outline-none focus:border-blue-500 transition-colors" placeholder="Share your knowledge..."></textarea>
            <div class="flex justify-end gap-3">
                <button @click="isAnnotating = false" class="px-4 py-2 text-white/50 hover:text-white text-sm font-bold uppercase">Cancel</button>
                <button @click="submitAnnotation" class="px-6 py-2 bg-blue-500 hover:bg-blue-400 text-white text-sm font-bold uppercase rounded-lg transition-colors">Post Note</button>
            </div>
        </div>
    </div>
</div>