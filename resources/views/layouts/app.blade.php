<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing CRM</title>

    <!-- SCRIPT ANTI-KEDIP (FOUC) -->
    <!-- Dieksekusi paling awal untuk mencegah layar berkedip putih saat di-refresh -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{
        sidebarOpen: false,
        darkMode: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }"
    class="bg-slate-50 dark:bg-slate-900 font-sans text-black dark:text-slate-100 antialiased flex h-screen overflow-hidden transition-colors duration-300">

    <!-- Overlay Backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 z-40 md:hidden" style="display: none;">
    </div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="w-64 bg-white dark:bg-slate-800 border-r-2 border-black dark:border-white flex flex-col h-full shrink-0 fixed inset-y-0 left-0 z-50 transform transition duration-200 ease-in-out md:relative md:translate-x-0">
        <div class="h-16 flex items-center justify-between px-6 border-b-2 border-black dark:border-white shrink-0">
            <h1 class="font-bold text-xl tracking-tight dark:text-white">CRM<span
                    class="text-blue-600 dark:text-[#93c5fd]">.</span>Internal</h1>
            <!-- Close Sidebar Button (Mobile Only) -->
            <button @click="sidebarOpen = false"
                class="md:hidden p-1 border-2 border-black dark:border-white rounded-sm shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none bg-white dark:bg-slate-700 dark:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <!-- Menu Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('dashboard') ? 'border-2 border-black dark:border-white bg-[#93c5fd] text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                Dashboard
            </a>

            <!-- Menu Kelola Leads -->
            <a href="{{ route('leads.index') }}"
                class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('leads.*') ? 'border-2 border-black dark:border-white bg-[#93c5fd] text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                Kelola Leads
            </a>

            <!-- Menu Reports -->
            <a href="{{ route('reports.index') }}"
                class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('reports.*') ? 'border-2 border-black dark:border-white bg-[#93c5fd] text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                Reports
            </a>

            <!-- Menu Users (Admin Only) -->
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}"
                    class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('users.*') ? 'border-2 border-black dark:border-white bg-[#93c5fd] text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                    Users (Admin)
                </a>
            @endif
        </nav>

        <div class="p-4 border-t-2 border-black dark:border-white shrink-0">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 font-bold text-red-600 dark:text-[#fca5a5] rounded-sm border-2 border-transparent hover:border-black dark:hover:border-white hover:bg-red-50 dark:hover:bg-slate-700 transition-all">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden w-full">
        <!-- Topbar -->
        <header
            class="h-16 bg-white dark:bg-slate-800 border-b-2 border-black dark:border-white flex items-center justify-between px-4 md:px-8 shrink-0 transition-colors duration-300">
            <div class="flex items-center gap-3 md:gap-0">
                <!-- Hamburger Menu Button -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="md:hidden flex items-center justify-center p-2 border-2 border-black dark:border-white rounded-sm shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] bg-white dark:bg-slate-700 dark:text-white hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h2
                    class="font-bold text-lg md:text-xl truncate max-w-[150px] sm:max-w-xs md:max-w-none dark:text-white">
                    @yield('header_title', 'Dashboard')
                </h2>
            </div>

            <div class="flex items-center gap-4 shrink-0">
                <!-- Tombol Toggle Dark Mode (Neo-Brutalism Style) -->
                <button @click="toggleTheme()"
                    class="flex items-center justify-center p-2 border-2 border-black dark:border-white rounded-sm shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] bg-white dark:bg-slate-700 hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none transition-all">
                    <!-- Icon Sun (Muncul di Dark Mode) -->
                    <svg x-show="darkMode" style="display: none;" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Icon Moon (Muncul di Light Mode) -->
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-800"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <div class="flex items-center gap-2">
                    <span
                        class="text-sm font-semibold hidden sm:inline-block dark:text-slate-100">{{ auth()->user()->name }}</span>
                    <span
                        class="text-xs px-2 py-1 bg-slate-200 dark:bg-slate-700 dark:text-white border border-black dark:border-white rounded-sm font-bold">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @if (session('success'))
                <div
                    class="mb-6 bg-[#86efac] border-2 border-black dark:border-white p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] flex justify-between items-center text-black">
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

</body>

</html>
