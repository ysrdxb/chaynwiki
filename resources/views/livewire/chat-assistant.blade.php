{{-- Floating Chat Widget --}}
<div class="fixed bottom-6 right-6 z-50" x-data="{ show: @entangle('isOpen') }">
    
    {{-- Chat Toggle Button --}}
    <button
        wire:click="toggle"
        class="w-16 h-16 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white shadow-2xl shadow-blue-500/20 flex items-center justify-center transition-all hover:scale-110 active:scale-95 border border-white/5"
        :class="{ 'scale-0 opacity-0': show }"
    >
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
    </button>

    {{-- Chat Window --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="absolute bottom-0 right-0 w-[380px] max-h-[600px] bg-[#0A0A14]/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl shadow-black/50 overflow-hidden flex flex-col"
        style="display: none;"
    >
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-purple-800 px-5 py-4 flex items-center justify-between border-b border-white/10 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-black text-[11px] uppercase tracking-[0.2em] italic">ChaynWiki AI</h3>
                    <p class="text-white/40 text-[9px] font-black uppercase tracking-widest italic mt-0.5">Global Archive Assistant</p>
                </div>
            </div>
            <button wire:click="close" class="text-white/40 hover:text-white transition-colors relative z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- AI Status Warning --}}
        @if(!$aiAvailable)
            <div class="bg-amber-500/10 border-b border-amber-500/20 px-4 py-2 flex items-center gap-2 text-amber-400 text-xs">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>AI is currently offline. Enable a provider in .env or start Ollama.</span>
                <button wire:click="checkAI" class="ml-auto underline hover:no-underline">Retry</button>
            </div>
        @endif

        {{-- Messages Area --}}
        <div 
            class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth" 
            id="chat-messages"
            x-ref="messageContainer"
            x-init="$watch('show', value => { if(value) { $nextTick(() => { $refs.messageContainer.scrollTop = $refs.messageContainer.scrollHeight }) } })"
        >
            {{-- Welcome Message --}}
            @if(empty($messages))
                <div class="text-center py-8">
                    <div class="w-16 h-16 rounded-full bg-brand-600/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h4 class="text-white font-semibold mb-2">How can I help?</h4>
                    <p class="text-gray-400 text-sm">Ask me anything about music, artists, or genres.</p>
                </div>
            @endif

            {{-- Message History --}}
            @foreach($messages as $msg)
                <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}" x-init="$nextTick(() => { $refs.messageContainer.scrollTop = $refs.messageContainer.scrollHeight })">
                    <div class="max-w-[85%] {{ $msg['role'] === 'user' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/10' : 'bg-white/5 text-gray-200' }} rounded-2xl px-5 py-3.5 text-xs font-medium {{ $msg['role'] === 'user' ? 'rounded-br-sm' : 'rounded-bl-sm border border-white/5' }}">
                        <div class="prose prose-sm prose-invert max-w-none prose-p:leading-relaxed prose-pre:bg-black/30 prose-pre:border prose-pre:border-white/10 font-medium">
                            {!! Str::markdown($msg['content']) !!}
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Loading Indicator --}}
            @if($isLoading)
                <div class="flex justify-start" x-init="$nextTick(() => { $refs.messageContainer.scrollTop = $refs.messageContainer.scrollHeight })">
                    <div class="bg-white/5 rounded-2xl rounded-bl-sm px-5 py-4 border border-white/5">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Suggestions --}}
        @if(empty($messages) && !empty($suggestions))
            <div class="px-4 pb-2 flex flex-wrap gap-2">
                @foreach($suggestions as $suggestion)
                    <button
                        wire:click="askSuggestion('{{ addslashes($suggestion) }}')"
                        class="text-xs px-3 py-1.5 bg-white/5 hover:bg-white/10 text-gray-300 rounded-full border border-white/10 transition-all"
                    >
                        {{ $suggestion }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Input Area --}}
        <div class="border-t border-white/10 p-4 bg-secondary/50">
            <form wire:submit="sendMessage" class="flex items-center gap-3">
                <input
                    type="text"
                    wire:model="message"
                    placeholder="Ask about music history..."
                    class="flex-1 bg-white/5 border border-white/5 rounded-xl px-5 py-3 text-white placeholder-white/10 text-xs font-black uppercase tracking-widest focus:border-blue-500/50 focus:ring-0 transition-all italic"
                    @if(!$aiAvailable) disabled @endif
                />
                <button
                    type="submit"
                    class="w-11 h-11 bg-blue-600 hover:bg-blue-500 rounded-xl flex items-center justify-center text-white transition-all disabled:opacity-50 shadow-lg shadow-blue-500/20 active:scale-95"
                    @if(!$aiAvailable || $isLoading) disabled @endif
                >
                    <svg class="w-5 h-5 translate-x-px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>

            {{-- Clear History --}}
            @if(!empty($messages))
                <div class="text-center mt-2">
                    <button wire:click="clearHistory" class="text-xs text-gray-500 hover:text-gray-300 transition-colors">
                        Clear conversation
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
