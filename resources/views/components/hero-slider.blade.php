<div class="swiper heroSwiper mb-10 overflow-hidden rounded-3xl">

    <div class="swiper-wrapper">

        @foreach(array_slice($trending,0,5) as $anime)

            <div class="swiper-slide relative">

                <img
                    src="{{ $anime['poster'] }}"
                    class="h-[250px] w-full object-cover
                           sm:h-[320px]
                           lg:h-[460px]">

                <div
                    class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent">
                </div>

                <div
                    class="absolute left-5 top-1/2 max-w-xl -translate-y-1/2
                           sm:left-10
                           lg:left-16">

                    <span
                        class="rounded-lg bg-sky-500 px-3 py-1 text-sm">

                        Ongoing

                    </span>

                    <h2
                        class="mt-5 text-2xl font-bold
                               sm:text-4xl
                               lg:text-6xl">

                        {{ $anime['title'] }}

                    </h2>

                    <p class="mt-4 text-zinc-300">

                        Episode {{ $anime['episodes'] }}

                        •

                        {{ $anime['latestReleaseDate'] }}

                    </p>

                    <a
                        href="{{ route('anime.show',$anime['animeId']) }}"
                        class="mt-8 inline-flex items-center gap-2 rounded-xl bg-sky-500 px-8 py-3 font-semibold transition hover:bg-sky-600">

                        ▶ Watch Now

                    </a>

                </div>

            </div>

        @endforeach

    </div>

    <div class="swiper-pagination"></div>

</div>