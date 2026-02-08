<x-master-layout>
    @push('seo')
        <meta property="og:title" content="@yield('og_title', 'ChaynWiki')">
        <meta property="og:description" content="@yield('og_description', 'The community-driven music encyclopedia.')">
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
        <meta name="twitter:card" content="summary_large_image">
    @endpush
    
    @push('styles')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=MODERNIZ:400,700&display=swap">
    @push('styles')
        <style>
            :root {
                @if(isset($article) && $article->analysis && $article->analysis->ambient_signature)
                    --ambient-gradient: {{ $article->analysis->ambient_gradient_css }};
                @endif
            }
        </style>
    @endpush
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
