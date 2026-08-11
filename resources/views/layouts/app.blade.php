<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing CRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans text-black antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r-2 border-black flex flex-col h-full shrink-0">
        <div class="h-16 flex items-center px-6 border-b-2 border-black">
            <h1 class="font-bold text-xl tracking-tight">CRM<span class="text-blue-600">.</span>Internal</h1>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <!-- Menu Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('dashboard') ? 'border-2 border-black bg-[#93c5fd] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'border-2 border-transparent hover:border-black hover:bg-slate-100' }}">
                Dashboard
            </a>

            <!-- Menu Kelola Leads -->
            <a href="{{ route('leads.index') }}"
                class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('leads.*') ? 'border-2 border-black bg-[#93c5fd] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'border-2 border-transparent hover:border-black hover:bg-slate-100' }}">
                Kelola Leads
            </a>

            <!-- Menu Reports -->
            <a href="#"
                class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('reports.*') ? 'border-2 border-black bg-[#93c5fd] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'border-2 border-transparent hover:border-black hover:bg-slate-100' }}">
                Reports
            </a>

            <!-- Menu Users (Admin Only) -->
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}"
                    class="block px-4 py-2 font-semibold rounded-sm transition-all {{ request()->routeIs('users.*') ? 'border-2 border-black bg-[#93c5fd] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'border-2 border-transparent hover:border-black hover:bg-slate-100' }}">
                    Users (Admin)
                </a>
            @endif
        </nav>

        <div class="p-4 border-t-2 border-black">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 font-bold text-red-600 rounded-sm border-2 border-transparent hover:border-black hover:bg-red-50 transition-all">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b-2 border-black flex items-center justify-between px-8 shrink-0">
            <h2 class="font-bold text-lg">@yield('header_title', 'Dashboard')</h2>
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold">{{ auth()->user()->name }}</span>
                <span
                    class="text-xs px-2 py-1 bg-slate-200 border border-black rounded-sm">{{ auth()->user()->role }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-8">
            @if (session('success'))
                <div
                    class="mb-6 bg-[#86efac] border-2 border-black p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] flex justify-between items-center">
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

</body>

</html>
