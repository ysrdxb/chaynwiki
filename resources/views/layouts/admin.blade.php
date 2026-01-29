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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#030308',
                        accent: '#3b82f6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-dark text-slate-200 antialiased overflow-x-hidden">
    
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-black/40 backdrop-blur-3xl border-r border-white/5 flex flex-col fixed h-screen z-50">
            <div class="p-8">
                <a href="{{ route('home') }}" class="text-2xl font-display font-black tracking-tighter text-gradient">
                    CHAYNWIKI
                    <span class="block text-[10px] tracking-widest text-[#3b82f6] opacity-60 mt-1">COMMAND CENTER</span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                <a href="/admin/dashboard" class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Content</div>
                <a href="/admin/articles" class="sidebar-item {{ request()->is('admin/articles*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Articles
                </a>
                <a href="/admin/revisions" class="sidebar-item {{ request()->is('admin/revisions*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Moderation Queue
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Community</div>
                <a href="/admin/users" class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Users
                </a>
            </nav>

            <div class="p-6 border-t border-white/5 mx-2 mb-2 rounded-2xl bg-white/[0.02]">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600 to-indigo-600 flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <div class="text-sm font-bold truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-brand-400 font-bold uppercase">{{ auth()->user()->role }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-10 relative">
            <!-- Background Decoration -->
            <div class="fixed inset-0 pointer-events-none z-0">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-600/10 blur-[150px] rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-600/5 blur-[120px] rounded-full"></div>
            </div>

            <div class="relative z-10">
                <header class="flex justify-between items-center mb-10">
                    <div>
                        <h1 class="text-3xl font-display font-black">@yield('header', 'Overview')</h1>
                        <p class="text-slate-400 text-sm mt-1">@yield('subheader', 'Platform operational status.')</p>
                    </div>
                    <div class="flex items-center space-y-0 space-x-4">
                        <div class="flex items-center px-4 py-2 rounded-xl bg-white/[0.03] border border-white/5">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 pulse"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">System Live</span>
                        </div>
                    </div>
                </header>

                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
