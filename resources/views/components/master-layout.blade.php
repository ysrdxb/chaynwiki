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
                        brand: {
                            50: '#f0f7ff', 100: '#e0effe', 200: '#bae2fd', 300: '#7cc8fb', 400: '#38acf8',
                            500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e', 950: '#082f49',
                        },
                        dark: {
                            DEFAULT: '#05050a',
                            surface: '#0c0c14',
                            elevated: '#151522',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    fontSize: {
                        '10xl': '10rem',
                        '11xl': '12rem',
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
    
    <!-- Global Styles -->
    <style>
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #030308; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
        
        [x-cloak] { display: none !important; }
        
        .text-gradient {
            background: linear-gradient(to bottom right, #fff 20%, #7dd3fc 50%, #38bdf8 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Skeleton Loading Animation */
        @keyframes skeleton-shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skeleton-v2 {
            background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 1.5s ease-in-out infinite;
            border-radius: 8px;
        }

        /* Fade In Animation */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#030308] min-h-screen text-slate-400 overflow-x-hidden selection:bg-blue-500 selection:text-white">
    <!-- Background Noise/Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-blue-900/5 via-[#050510] to-[#050510]"></div>
        <div id="ambient-glow" class="absolute inset-0 opacity-40 blur-[150px] mix-blend-screen transition-all duration-1000" style="background: var(--ambient-gradient, transparent);"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.02]"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10">
        {{ $slot }}
    </div>

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
