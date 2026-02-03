<x-master-layout>
    @push('seo')
        <meta property="og:title" content="@yield('og_title', 'ChaynWiki')">
        <meta property="og:description" content="@yield('og_description', 'The community-driven music encyclopedia.')">
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
        <meta name="twitter:card" content="summary_large_image">
    @endpush
    
    @push('styles')
        <style>
            :root {
                @if(isset($article) && $article->analysis && $article->analysis->ambient_signature)
                    --ambient-gradient: {{ $article->analysis->ambient_gradient_css }};
                @endif
            }
            .reading-progress {
                position: fixed;
                top: 0;
                left: 0;
                height: 3px;
                background: linear-gradient(90deg, #2a91ff, #a855f7, #ec4899);
                z-index: 9999;
                transition: width 0.1s linear;
            }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            /* Refined base colors for wiki layout */
            .bg-primary { background-color: #0a0a12; }
            .bg-secondary { background-color: #0f0f1a; }
            .bg-tertiary { background-color: #151522; }
        </style>
    @endpush

    <!-- Navigation -->
    <x-navigation />

    <!-- Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />
</x-master-layout>
