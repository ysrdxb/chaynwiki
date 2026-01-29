<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ChaynWiki'))</title>
    
    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'The community-driven music encyclopedia.')">
    @stack('seo')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
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
    
    <!-- Global Styles -->
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #030308; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3b82f6, #8b5cf6); border-radius: 4px; }
        [x-cloak] { display: none !important; }
        
        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, #60a5fa 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#030308] min-h-screen text-white overflow-x-hidden selection:bg-brand-500 selection:text-white">
    <!-- Background Noise/Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-brand-900/10 via-[#030308] to-[#030308]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03]"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10">
        {{ $slot }}
    </div>

    <!-- Global Components -->
    <x-toast-container />
    
    @auth
        <livewire:chat-assistant />
    @endauth

    @stack('scripts')
</body>
</html>
