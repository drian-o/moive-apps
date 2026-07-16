@props([
    'id',
    'image',
    'title',
    'episode',
    'route' => 'anime.show',
])

<a href="{{ route($route, $id) }}" class="group block">
    <div
        class="overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 transition duration-300 hover:border-sky-500 hover:shadow-xl">

        {{-- Poster --}}
        <div class="relative overflow-hidden">

            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                loading="lazy"
                class="h-56 w-full object-cover transition duration-500 group-hover:scale-110
                       sm:h-64
                       md:h-72
                       lg:h-80">

            <div
                class="absolute left-2 top-2 rounded-lg bg-sky-500 px-2 py-1 text-[11px] font-semibold text-white shadow">

                {{ $episode }}

            </div>

        </div>

        {{-- Info --}}
        <div class="p-3 sm:p-4">

            <h3
                class="line-clamp-2 min-h-[42px] text-sm font-semibold leading-5 text-white transition group-hover:text-sky-400">

                {{ $title }}

            </h3>

            <div class="mt-3 flex items-center justify-between">

                <span class="text-xs text-zinc-500">

                    AniFlix

                </span>

                <span
                    class="rounded-full bg-zinc-800 px-2 py-1 text-[10px] text-zinc-400">

                    HD

                </span>

            </div>

        </div>

    </div>

</a>