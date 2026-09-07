<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRM Internal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Pastikan CDN Alpine.js terpasang -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<!-- State Alpine Utama: Mengatur Sidebar Open/Close dan Dark Mode -->

<body x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    init() {
        this.$watch('darkMode', val => localStorage.setItem('darkMode', val));
    }
}" :class="{ 'dark': darkMode }"
    class="bg-slate-50 dark:bg-slate-900 text-black dark:text-white transition-colors duration-300 antialiased overflow-hidden">

    <div class="flex inset-0 flex h-[100dvh] w-full overflow-hidden">

        <!-- Backdrop Blur (Hanya muncul di Mobile saat Sidebar Terbuka) -->
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden" style="display: none;"></div>

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-800 border-r-2 border-black dark:border-white shadow-[4px_0px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_0px_0px_0px_rgba(255,255,255,1)] flex flex-col h-full transition-transform duration-300 ease-in-out">

            <!-- Header Logo -->
            <div
                class="h-16 flex items-center justify-between px-4 border-b-2 border-black dark:border-white bg-[#d8b4fe] transition-colors shrink-0">
                <h1 class="font-black text-xl text-black tracking-widest uppercase">CRM.Internal</h1>
                <!-- Tombol tutup khusus mobile -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden text-black hover:scale-110 font-black text-2xl transition-transform">&times;</button>
            </div>

            <!-- Menu Navigasi (Aktifkan class berdasarkan route) -->
            <nav class="flex-1 overflow-y-auto p-4 flex flex-col gap-2">
                <a href="{{ url('/dashboard') }}"
                    class="block p-3 font-bold border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-[#93c5fd] hover:text-black transition-all {{ request()->is('dashboard') ? 'bg-[#93c5fd] border-black dark:border-white text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'text-slate-700 dark:text-slate-300' }}">
                    Dashboard
                </a>
                <a href="{{ route('leads.index') }}"
                    class="block p-3 font-bold border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-[#93c5fd] hover:text-black transition-all {{ request()->routeIs('leads.*') ? 'bg-[#93c5fd] border-black dark:border-white text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'text-slate-700 dark:text-slate-300' }}">
                    Kelola Leads
                </a>
                <a href="{{ route('statuses.index') }}"
                    class="block p-3 font-bold border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-[#86efac] hover:text-black transition-all {{ request()->routeIs('statuses.*') ? 'bg-[#86efac] border-black dark:border-white text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'text-slate-700 dark:text-slate-300' }}">
                    Atur Papan (Status)
                </a>
                <a href="{{ url('/reports') }}"
                    class="block p-3 font-bold border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-[#fde047] hover:text-black transition-all {{ request()->is('reports') ? 'bg-[#fde047] border-black dark:border-white text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'text-slate-700 dark:text-slate-300' }}">
                    Reports
                </a>
                <a href="{{ url('/users') }}"
                    class="block p-3 font-bold border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-[#fca5a5] hover:text-black transition-all {{ request()->is('users') ? 'bg-[#fca5a5] border-black dark:border-white text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'text-slate-700 dark:text-slate-300' }}">
                    Users (Admin)
                </a>
            </nav>

            <!-- Logout Menu -->
            <div class="p-4 border-t-2 border-black dark:border-white shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left p-3 font-bold text-[#fca5a5] hover:bg-[#fca5a5] hover:text-black border-2 border-transparent hover:border-black dark:hover:border-white transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col h-full overflow-hidden transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'">

            <!-- TOPBAR -->
            <header
                class="h-16 bg-white dark:bg-slate-800 border-b-2 border-black dark:border-white flex items-center justify-between px-4 lg:px-6 shrink-0 transition-colors">
                <div class="flex items-center gap-4">
                    <!-- Tombol Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 bg-[#fde047] border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-bold" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="font-black text-lg md:text-xl tracking-wide uppercase">@yield('header_title')</h2>
                </div>

                <!-- Bagian Kanan Topbar -->
                <div class="flex items-center gap-3">
                    <!-- Tombol Toggle Dark Mode -->
                    <button @click="darkMode = !darkMode"
                        class="p-2 bg-white dark:bg-slate-700 border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all text-black dark:text-white">
                        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg x-show="darkMode" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- User Profil -->
                    <div
                        class="hidden md:flex items-center gap-2 px-3 py-1.5 border-2 border-black dark:border-white bg-slate-100 dark:bg-slate-700 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]">
                        <span class="font-bold text-sm">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <span
                            class="px-2 py-0.5 text-xs font-black bg-[#93c5fd] border-2 border-black dark:border-white text-black uppercase">{{ auth()->user()->role ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <!-- KONTEN UTAMA (Scrollable) -->
            <main
                class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-6 bg-[#f8fafc] dark:bg-slate-900 transition-colors">
                @yield('content')
            </main>

        </div>
    </div>
</body>

</html>
