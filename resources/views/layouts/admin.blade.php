<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-slate-950 text-white">

<div class="flex min-h-screen">

    @include('admin.partials.sidebar')

    <div class="flex flex-1 flex-col">

        @include('admin.partials.navbar')

        <main class="flex-1 p-8">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>