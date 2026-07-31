@props([
    'id',
    'image',
    'title',
    'episode',
    'route' => 'anime.show',
])

<a href="{{ route($route, $id) }}" class="group block">

    <div
        class="overflow-hidden rounded-2xl border border-white/5 bg-[#111827] transition-all duration-300 hover:-translate-y-1 hover:border-sky-500/30">

        {{-- Poster --}}
        <div class="relative aspect-video overflow-hidden">

            <img
                src="{{ str_contains($image,'nekopoi.care')
                    ? route('image.proxy',['url'=>$image])
                    : $image }}"
                alt="{{ $title }}"
                loading="lazy"
                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>

            {{-- Time --}}
            <div
                class="absolute left-2 top-2 rounded bg-black/80 px-2 py-1 text-[10px] font-bold text-white backdrop-blur">

                23:40

            </div>

            {{-- Episode --}}
            <div
                class="absolute right-2 top-2 rounded bg-sky-500 px-2 py-1 text-[10px] font-bold text-white">

                {{ $episode }}

            </div>

        </div>

        {{-- Info --}}
        <div class="p-3">

            <p class="mb-1 text-[11px] uppercase tracking-wide text-zinc-500">
                Latest Episode
            </p>

            <h3
                class="line-clamp-2 min-h-[42px] text-sm font-semibold leading-5 text-white transition group-hover:text-sky-400">

                {{ $title }}

            </h3>

            <div class="mt-3 flex items-center justify-between">

                <div class="flex gap-2">

                    <span
                        class="rounded bg-zinc-800 px-2 py-1 text-[10px] font-semibold text-white">

                        SUB 9

                    </span>

                    <span
                        class="rounded bg-zinc-800 px-2 py-1 text-[10px] font-semibold text-white">

                        DUB 1

                    </span>

                </div>

                <div
                    class="h-2 w-2 rounded-full bg-green-500">
                </div>

            </div>

        </div>

    </div>

</a>