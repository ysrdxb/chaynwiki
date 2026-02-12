<x-master-layout>
    @push('seo')
        <meta name="description" content="@yield('meta_description', 'The community-driven music encyclopedia. Discover hidden stories behind your favorite songs, artists, and genres.')">
        <meta name="keywords" content="music wiki, music encyclopedia, song meanings, artist bios, music community, chaynwiki">
        <meta property="og:title" content="@yield('og_title', 'ChaynWiki — Music Encyclopedia')">
        <meta property="og:description" content="@yield('og_description', 'The community-driven music encyclopedia.')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('og_title', 'ChaynWiki')">
        <meta name="twitter:description" content="@yield('og_description', 'The community-driven music encyclopedia.')">
        <link rel="canonical" href="{{ url()->current() }}">
    @endpush
    
    @push('styles')
        <style>
            :root {
                @if(isset($article) && $article->analysis && $article->analysis->ambient_signature)
                    --ambient-gradient: {{ $article->analysis->ambient_gradient_css }};
                @endif
            }
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
