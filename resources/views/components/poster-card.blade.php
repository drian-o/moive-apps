@props([
    'id',
    'image',
    'title',
    'episode',
    'route' => 'anime.show',
])

<a
    href="{{ route($route, $id) }}"
    class="group block w-full">

    <div class="overflow-hidden rounded-xl border border-white/5 bg-zinc-900">

        <div class="relative aspect-[2/3] overflow-hidden">

            <img
                src="{{ str_contains($image,'nekopoi.care')
                    ? route('image.proxy',['url'=>$image])
                    : $image }}"
                alt="{{ $title }}"
                loading="lazy"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

            <span
                class="absolute right-2 top-2 rounded-md bg-black/70 px-2 py-1 text-[10px] font-semibold text-white backdrop-blur">

                {{ $episode }}

            </span>

        </div>

        <div class="p-3">

            <h3 class="line-clamp-2 text-sm font-semibold leading-5 text-white group-hover:text-sky-400">

                {{ $title }}

            </h3>

            <div class="mt-2 flex items-center gap-2 text-xs text-zinc-500">

                <span>{{ $episode }}</span>

                <span>•</span>

                <span>HD</span>

            </div>

        </div>

    </div>

</a>