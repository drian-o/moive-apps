<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0F172A]">

<div class="grid min-h-screen grid-cols-2">

    <!-- Left -->
    <div class="flex flex-col justify-center bg-[#020617] px-20">

        <h1 class="mb-6 text-5xl font-bold text-white">
            ANIMEBORAD
        </h1>

        <h2 class="mb-4 text-4xl font-bold text-white leading-tight">
            Manage Everything<br>
            In One Dashboard
        </h2>

        <p class="text-lg text-slate-400">
            Kelola Anime, Manga, Comic, Donghua, Movie,
            User dan API hanya dari satu panel admin.
        </p>

    </div>

    <!-- Right -->
    <div class="flex items-center justify-center bg-[#111827]">

        <div class="w-full max-w-md">

            <h2 class="mb-8 text-3xl font-bold text-white">
                Login
            </h2>

            {{-- Error Login --}}
            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-500 bg-red-500/10 p-4 text-red-400">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">

                @csrf

                <!-- Email -->
                <div class="mb-5">

                    <label class="mb-2 block text-sm text-slate-300">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900 px-5 py-4 text-white outline-none transition focus:border-blue-500"
                        placeholder="admin@email.com">

                </div>

                <!-- Password -->
                <div class="mb-5">

                    <label class="mb-2 block text-sm text-slate-300">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900 px-5 py-4 text-white outline-none transition focus:border-blue-500"
                        placeholder="••••••••">

                </div>

                <!-- Remember -->
                <div class="mb-6 flex items-center gap-2">

                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        class="h-4 w-4 rounded border-slate-700 bg-slate-900">

                    <label for="remember" class="text-sm text-slate-300">
                        Remember Me
                    </label>

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-4 font-semibold text-white transition hover:bg-blue-700">

                    Login

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>