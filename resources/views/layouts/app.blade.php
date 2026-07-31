<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', $setting->site_title ?? 'AniFlix')
    </title>

    <meta
        name="description"
        content="{{ $setting->site_description ?? '' }}"
    >

    <meta
        name="keywords"
        content="{{ $setting->site_keywords ?? '' }}"
    >

    <meta
        name="theme-color"
        content="{{ $setting->theme_color ?? '#0ea5e9' }}"
    >

    @if($setting && $setting->favicon)
        <link
            rel="icon"
            href="{{ asset('storage/'.$setting->favicon) }}"
        >
    @endif

    @if($setting && $setting->logo)
        <meta
            property="og:image"
            content="{{ asset('storage/'.$setting->logo) }}"
        >
    @endif

    {{-- Swiper CSS --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        :root {
            --theme: {{ $setting->theme_color ?? '#0ea5e9' }};
        }

        .theme-text {
            color: var(--theme) !important;
        }

        .theme-bg {
            background: var(--theme) !important;
        }

        .theme-border {
            border-color: var(--theme) !important;
        }

        .theme-hover:hover {
            color: var(--theme) !important;
        }

        .theme-bg-hover:hover {
            background: var(--theme) !important;
        }

        /* Swiper base */
        .swiper {
            width: 100%;
            overflow: hidden;
        }

        .swiper-wrapper {
            align-items: stretch;
        }

        .swiper-slide {
            height: auto;
        }
    </style>

    {{-- CSS dari halaman --}}
    @stack('styles')
</head>

<body class="bg-zinc-950 text-white">

<div class="min-h-screen bg-zinc-950">

    {{-- Desktop Sidebar --}}
    <div class="fixed inset-y-0 left-0 z-50 hidden lg:block">
        @include('components.sidebar')
    </div>

    <div class="flex min-h-screen flex-col lg:ml-[280px]">

        @include('components.navbar')

        <main class="flex-1 px-4 py-5 sm:px-6 lg:px-8">
            @yield('content')
        </main>

    </div>

</div>

{{-- Mobile Sidebar --}}
<div
    id="mobile-sidebar"
    class="fixed inset-0 z-[9999] hidden lg:hidden"
>
    <div
        id="mobile-sidebar-backdrop"
        class="absolute inset-0 bg-black/70 backdrop-blur-sm"
    ></div>

    <div class="relative h-full w-[280px] bg-zinc-900 shadow-2xl">
        @include('components.sidebar')
    </div>
</div>

{{-- Swiper JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

{{-- JavaScript dari halaman --}}
@stack('scripts')

</body>
</html>