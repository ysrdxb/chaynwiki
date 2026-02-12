<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Command Center | ChaynWiki Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#030308',
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc7fb',
                            400: '#38aaf7',
                            500: '#0e8fe7',
                            600: '#0272c7',
                            700: '#035ba1',
                            800: '#074d85',
                            900: '#0c416e',
                            950: '#082949',
                        },
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-[#0d1117] text-white antialiased overflow-x-hidden selection:bg-blue-500/30">
    
    <div class="flex min-h-screen relative">
        {{-- Ambient Background --}}
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-600/5 blur-[120px] rounded-full mix-blend-screen"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/5 blur-[120px] rounded-full mix-blend-screen"></div>
        </div>

        <!-- Sidebar -->
        <aside class="w-72 bg-[#161b22]/80 backdrop-blur-xl border-r border-white/5 flex flex-col fixed h-screen z-50 transition-all duration-300">
            <div class="p-8 border-b border-white/5">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-black shadow-lg shadow-blue-500/20">C</div>
                    <div>
                        <span class="block text-[14px] font-black tracking-tighter text-white uppercase leading-none">CHAYNWIKI</span>
                        <span class="block text-[9px] tracking-[0.2em] text-blue-400 font-bold mt-1">COMMAND</span>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-xl transition-all {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <div class="pt-6 pb-3 px-4 text-[10px] font-black text-white/20 uppercase tracking-widest">Global Content</div>
                
                <a href="{{ route('admin.articles') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-xl transition-all {{ request()->is('admin/articles*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Articles
                </a>
                <a href="{{ route('admin.revisions') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-xl transition-all {{ request()->is('admin/revisions*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Moderation Queue
                </a>
                <a href="{{ route('admin.batch-analysis') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-xl transition-all {{ request()->is('admin/batch-analysis*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    Batch Analysis
                </a>
                <a href="{{ route('admin.knowledge-graph') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-xl transition-all {{ request()->is('admin/knowledge-graph*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Knowledge Graph
                </a>

                <div class="pt-6 pb-3 px-4 text-[10px] font-black text-white/20 uppercase tracking-widest">Community</div>
                
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-xl transition-all {{ request()->is('admin/users*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Users
                </a>
            </nav>

            <div class="p-6 border-t border-white/5 mx-2 mb-2">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-bold text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-blue-400 font-bold uppercase tracking-wider">{{ auth()->user()->role }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-12 relative z-10 w-full max-w-[calc(100vw-18rem)]">
            <header class="flex justify-between items-center mb-12">
                <div>
                    <h1 class="text-[32px] font-black text-white uppercase tracking-tighter leading-none">@yield('header', 'Overview')</h1>
                    <p class="text-white/40 text-[14px] font-medium mt-2">@yield('subheader', 'Platform operational status.')</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/20">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2 animate-pulse shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-blue-400">System Live</span>
                    </div>
                </div>
            </header>

            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
