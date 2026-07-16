<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_title ?? 'AniFlix' }}
    </title>

    <meta
        name="description"
        content="{{ $setting->site_description ?? '' }}">

    <meta
        name="keywords"
        content="{{ $setting->site_keywords ?? '' }}">

    <meta
        name="theme-color"
        content="{{ $setting->theme_color ?? '#0ea5e9' }}">

    @if($setting && $setting->favicon)
        <link
            rel="icon"
            href="{{ asset('storage/'.$setting->favicon) }}">
    @endif

    @if($setting && $setting->logo)
        <meta property="og:image"
              content="{{ asset('storage/'.$setting->logo) }}">
    @endif

    <style>

        :root{

            --theme: {{ $setting->theme_color ?? '#0ea5e9' }};

        }

        .theme-text{
            color:var(--theme)!important;
        }

        .theme-bg{
            background:var(--theme)!important;
        }

        .theme-border{
            border-color:var(--theme)!important;
        }

        .theme-hover:hover{
            color:var(--theme)!important;
        }

        .theme-bg-hover:hover{
            background:var(--theme)!important;
        }

    </style>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-zinc-950 text-white">

<div class="flex min-h-screen">

    <aside class="hidden lg:flex">

        @include('components.sidebar')

    </aside>

    <div class="flex min-h-screen flex-1 flex-col">

        @include('components.navbar')

        <main
            class="flex-1 overflow-y-auto bg-zinc-950 px-4 py-5 sm:px-6 lg:px-8">

            @yield('content')

        </main>

    </div>

</div>

<div
    id="mobile-sidebar"
    class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm lg:hidden">

    <div class="h-full w-72 bg-zinc-900">

        @include('components.sidebar')

    </div>

</div>

</body>

</html>