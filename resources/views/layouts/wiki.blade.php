<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - ChaynWiki</title>
    <meta name="description" content="@yield('meta_description', 'The community-driven music encyclopedia.')">
    <meta property="og:title" content="@yield('og_title', 'ChaynWiki')">
    <meta property="og:description" content="@yield('og_description', 'The community-driven music encyclopedia.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
    <meta name="twitter:card" content="summary_large_image">
    @stack('seo')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-[#050511] min-h-screen text-white overflow-x-hidden selection:bg-brand-500 selection:text-white font-sans">
    
    <!-- Navigation -->
    <x-navigation />

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />
</body>
</html>
