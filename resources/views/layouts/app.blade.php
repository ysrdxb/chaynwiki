<x-master-layout>
    <!-- Navigation -->
    <x-navigation />

    <!-- Page Content -->
    <main class="pb-24">
        {{ $slot }}
    </main>
    
    <!-- Footer -->
    <x-footer />
</x-master-layout>
