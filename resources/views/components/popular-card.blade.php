@props([
    'anime',
    'rank',
])

<a
    href="{{ route('anime.show', $anime['animeId']) }}"
    class="group flex items-center gap-4 rounded-2xl bg-zinc-900/40 p-3 transition duration-300 hover:bg-zinc-800/60">

    {{-- Ranking --}}
    <div class="w-9 text-center">

        <span class="text-3xl font-black text-zinc-600 transition group-hover:text-sky-400">

            {{ str_pad($rank,2,'0',STR_PAD_LEFT) }}

        </span>

    </div>

    {{-- Poster --}}
    <div class="overflow-hidden rounded-xl flex-shrink-0">

        <img
            src="{{ $anime['poster'] }}"
            alt="{{ $anime['title'] }}"
            class="h-24 w-16 object-cover transition duration-500 group-hover:scale-110">

    </div>

    {{-- Info --}}
    <div class="min-w-0 flex-1">

        <h3
            class="line-clamp-2 text-sm font-semibold leading-5 text-white transition group-hover:text-sky-400">

            {{ $anime['title'] }}

        </h3>

        <p class="mt-1 line-clamp-2 text-xs text-zinc-500">

            Episode {{ $anime['episodes'] }}

        </p>

        <div class="mt-3 flex items-center justify-between text-xs">

            <span class="rounded bg-emerald-500/20 px-2 py-1 font-medium text-emerald-400">
                TV
            </span>

            <span class="text-zinc-400">

                ⭐ {{ $anime['score'] ?? 'N/A' }}

            </span>

        </div>

    </div>

</a>