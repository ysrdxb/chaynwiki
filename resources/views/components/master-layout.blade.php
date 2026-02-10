<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ChaynWiki'))</title>
    
    @php
        $seoTitle = trim(strip_tags($__env->yieldContent('title', config('app.name', 'ChaynWiki'))));
        $seoDescription = trim(strip_tags($__env->yieldContent('meta_description', 'The community-driven music encyclopedia.')));
        $seoImage = trim(strip_tags($__env->yieldContent('meta_image', asset('images/hero_background.png'))));
        $seoCanonical = trim(strip_tags($__env->yieldContent('canonical', url()->current())));
    @endphp

    <!-- Meta -->
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="{{ $seoCanonical }}">

    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ config('app.name', 'ChaynWiki') }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    @stack('seo')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Tailwind Configuration -->
    <script>
        window.tailwind = window.tailwind || {};
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 500: '#3b82f6' },
                        navy: { 900: '#0d1117', 950: '#0a0a0f' }
                    },
                    fontFamily: {
                        sans: ['MODERNIZ', '"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    letterSpacing: {
                        'tightest': '-0.06em',
                        'tighter': '-0.04em',
                        'ultra-tight': '-0.05em',
                        'mega-tight': '-0.02em',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Unified Card Hover Glow Effect */
        .card-premium-unified::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(
                600px circle at var(--mouse-x, 0) var(--mouse-y, 0),
                rgba(59, 130, 246, 0.08),
                transparent 40%
            );
            border-radius: inherit;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: -1;
        }
        .card-premium-unified:hover::before {
            opacity: 1;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#0d1117] min-h-screen text-white/70 overflow-x-hidden selection:bg-[#3b82f6] selection:text-white">
    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-blue-500/5 via-[#0d1117] to-[#0d1117]"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 flex flex-col min-h-screen">
        {{ $slot }}
    </div>

    <!-- Mouse Tracking Script for Unified Card Effect -->
    <script>
        document.addEventListener('mousemove', e => {
            for(const card of document.getElementsByClassName('card-premium-unified')) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            }
        });
    </script>

    <!-- Global Components -->
    <x-toast-container />
    
    <livewire:pulse-player />

    @auth
        <livewire:chat-assistant />
    @endauth

    @stack('scripts')
    @livewireScripts
    
    <script>
        // Clear AI context on navigation if not on a wiki page
        document.addEventListener('livewire:navigated', () => {
            if (!window.location.pathname.includes('/wiki/')) {
                Livewire.dispatch('updateContext', { context: null });
            }
        });
    </script>
</body>
</html>
