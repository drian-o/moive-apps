@props([
    'id',
    'image',
    'title',
    'episode',
    'route' => 'anime.show',
])

<a
    href="{{ route($route, $id) }}"
    class="group block">

    <article>

        {{-- Thumbnail --}}
        <div class="relative aspect-video overflow-hidden rounded-md border border-white/5 bg-zinc-900">

            <img
                src="{{ str_contains($image,'nekopoi.care')
                    ? route('image.proxy',['url'=>$image])
                    : $image }}"
                alt="{{ $title }}"
                loading="lazy"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

            {{-- Duration --}}
            <span class="absolute left-2 top-2 rounded bg-black/75 px-2 py-1 text-[10px] font-semibold text-white backdrop-blur">
                23:40
            </span>

            {{-- Comments --}}
            <span class="absolute bottom-2 left-2 flex items-center gap-1 rounded bg-black/70 px-2 py-1 text-[10px] text-white backdrop-blur">
                💬 0
            </span>

        </div>

        {{-- Info --}}
        <div class="mt-3 border-b border-white/5 pb-4">

            <p class="text-[11px] uppercase tracking-wider text-zinc-500">
                {{ strtoupper($episode) }}
            </p>

            <h3 class="mt-1 line-clamp-2 text-[15px] font-semibold leading-6 text-white transition group-hover:text-sky-400">
                {{ $title }}
            </h3>

            <div class="mt-3 flex items-center gap-2 text-[11px]">

                <span class="rounded border border-white/10 bg-zinc-900 px-2 py-1 font-semibold text-white">
                    SUB
                </span>

                <span class="rounded border border-white/10 bg-zinc-900 px-2 py-1 font-semibold text-white">
                    9
                </span>

                <span class="rounded border border-white/10 bg-zinc-900 px-2 py-1 font-semibold text-white">
                    AUD
                </span>

                <span class="rounded border border-white/10 bg-zinc-900 px-2 py-1 font-semibold text-white">
                    1
                </span>

                <span class="ml-auto h-3.5 w-3.5 rounded-full border-2 border-emerald-500"></span>

            </div>

        </div>

    </article>

</a>