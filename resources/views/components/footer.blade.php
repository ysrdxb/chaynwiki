<footer class="py-12 border-t border-white/10 bg-[#020617] relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-purple-600 flex items-center justify-center font-bold text-white">C</div>
                <span class="font-display font-bold text-xl text-white">ChaynWiki</span>
            </div>
            <div class="flex items-center gap-8 text-sm text-gray-500">
                <a href="#" wire:navigate class="hover:text-white transition-colors">About</a>
                <a href="#" wire:navigate class="hover:text-white transition-colors">Guidelines</a>
                <a href="#" wire:navigate class="hover:text-white transition-colors">API</a>
                <a href="#" wire:navigate class="hover:text-white transition-colors">Contact</a>
            </div>
            <div class="text-sm text-gray-600">
                © {{ date('Y') }} ChaynWiki. Built with 💙
            </div>
        </div>
    </div>
</footer>
