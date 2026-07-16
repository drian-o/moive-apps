<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r theme-border bg-zinc-900 transition-transform duration-300 lg:static lg:w-60 lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-16 items-center gap-3 border-b theme-border px-6">

        @if(!empty($setting?->logo))

            <img
                src="{{ asset('storage/'.$setting->logo) }}"
                alt="{{ $setting->site_name }}"
                class="h-10 w-auto">

        @endif
    </div>
    @php

        $menus = [

            [
                'icon' => '🏠',
                'name' => 'Home',
                'url'  => route('home'),
            ],

            [
                'icon' => '🎌',
                'name' => 'Anime',
                'url'  => route('anime.unlimited'),
            ],

            [
                'icon' => '🐉',
                'name' => 'Donghua',
                'url'  => route('donghua.home'),
            ],

            [
                'icon' => '🎬',
                'name' => 'Movie',
                'url'  => '#',
            ],

            [
                'icon' => '📖',
                'name' => 'Comic',
                'url'  => route('comic.index'),
            ],

            [
                'icon' => '🔥',
                'name' => 'Trending',
                'url'  => '#',
            ],

            [
                'icon' => '⭐',
                'name' => 'Popular',
                'url'  => '#',
            ],

            [
                'icon' => '❤️',
                'name' => 'Bookmark',
                'url'  => '#',
            ],

        ];

    @endphp

    {{-- Menu --}}
    <nav class="flex-1 space-y-2 p-3">

        @foreach($menus as $menu)

            @php
                $active = request()->url() == $menu['url'];
            @endphp

            <a
                href="{{ $menu['url'] }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                {{ $active
                    ? 'theme-bg text-white'
                    : 'text-zinc-300 hover:bg-zinc-800 theme-hover' }}">

                <span class="text-lg">

                    {{ $menu['icon'] }}

                </span>

                <span>

                    {{ $menu['name'] }}

                </span>

            </a>

        @endforeach

    </nav>

    {{-- Website Info --}}
    <div class="border-t theme-border p-4">

        <p class="font-semibold theme-text">

            {{ $setting->site_name ?? 'AniFlix' }}

        </p>

        <p class="mt-2 text-xs text-zinc-400">

            {{ $setting->site_description ?? 'Anime Streaming Website' }}

        </p>

    </div>

    {{-- Footer --}}
    <div class="border-t theme-border p-4 text-center text-xs text-zinc-500">

        © {{ date('Y') }}

        {{ $setting->site_name ?? 'AniFlix' }}

        <br>

        All Rights Reserved.

    </div>

</aside>