<header class="sticky top-0 z-30 border-b border-zinc-800 bg-[#10131d]/90 backdrop-blur-xl">

    <div class="flex h-16 items-center gap-4 px-4 lg:px-8">

        {{-- Mobile Menu --}}
        <button
            id="menu-toggle"
            class="rounded-lg p-2 transition hover:bg-zinc-800 lg:hidden">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>

            </svg>

        </button>

        {{-- Logo Mobile --}}
        <a
            href="{{ route('home') }}"
            class="text-xl font-black text-sky-400 lg:hidden">

@if(!empty($setting?->logo))
    <img
        src="{{ asset('storage/'.$setting->logo) }}"
        alt="{{ $setting->site_name }}"
        class="h-9 w-auto">
@endif

        </a>

        {{-- Search --}}
        <div class="relative flex-1">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>

            </svg>

            <input
                id="search"
                type="text"
                autocomplete="off"
                placeholder="Search anime..."
                class="h-12 w-full rounded-xl border border-zinc-700 bg-[#141923] pl-12 pr-5 text-sm text-white placeholder:text-zinc-500 focus:border-sky-500 focus:outline-none">

<div
    id="search-result"
    class="absolute left-0 top-full z-50 mt-2 hidden
           max-h-[450px]
           w-full
           overflow-y-auto
           rounded-2xl
           border border-zinc-800
           bg-[#141923]
           shadow-2xl">
</div>

        </div>

        {{-- Desktop Menu --}}
        <div class="ml-4 hidden items-center gap-2 lg:flex">

            <button class="rounded-lg p-2 transition hover:bg-zinc-800">
                🕒
            </button>

            <button class="rounded-lg p-2 transition hover:bg-zinc-800">
                🔖
            </button>

            <button class="rounded-lg p-2 transition hover:bg-zinc-800">
                ⚙️
            </button>

                <a
    href="{{ route('admin.login') }}"
    class="rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-600">

    Login

</a>

        </div>

    </div>

</header>