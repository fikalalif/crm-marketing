<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Marketing CRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center font-sans text-black">

    <div class="bg-white p-8 w-full max-w-md border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
        <h1 class="text-2xl font-bold mb-2">Marketing CRM</h1>
        <p class="text-gray-600 mb-6">Silakan login ke akun Anda.</p>

        <!-- Menampilkan Pesan Error -->
        @if ($errors->any())
            <div class="bg-[#fca5a5] border-2 border-black p-3 mb-6 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                <ul class="text-sm font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">
            @csrf <!-- Wajib untuk proteksi CSRF -->

            <div class="flex flex-col gap-1">
                <label for="email" class="font-bold text-sm">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="p-2 border-2 border-black focus:outline-none focus:bg-slate-100 transition-colors">
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="font-bold text-sm">Password</label>
                <input type="password" name="password" id="password" required
                    class="p-2 border-2 border-black focus:outline-none focus:bg-slate-100 transition-colors">
            </div>

            <button type="submit"
                class="mt-4 bg-[#93c5fd] font-bold py-2 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-[2px] active:translate-x-[2px] active:shadow-none transition-all">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
