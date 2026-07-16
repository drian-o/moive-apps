@extends('layouts.app')

@section('content')

<div class="space-y-12">

    {{-- Trending --}}
    <section>

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-3xl font-bold">
                🔥 Trending Now
            </h2>

            <a href="#" class="text-sky-400 hover:text-sky-300">
                View More →
            </a>

        </div>
<div class="flex gap-5 overflow-x-auto pb-4 no-scrollbar">

    @foreach($trending as $anime)

        <div class="w-[220px] flex-shrink-0">

            <x-anime-card
                :id="$anime['id']"
                :image="$anime['coverImage']['extraLarge']"
                :title="$anime['title']['english'] ?: $anime['title']['romaji']"
                :episode="'⭐ '.$anime['averageScore']"
            />

        </div>

    @endforeach

</div>

    </section>

    {{-- Release Calendar --}}
    <section>

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-3xl font-bold">
                📅 Release Calendar
            </h2>

        </div>

        <div class="flex flex-wrap gap-3">

            @foreach(['MON','TUE','WED','THU','FRI','SAT','SUN'] as $day)

                <button
                    class="rounded-xl bg-zinc-900 px-5 py-3 text-sm transition hover:bg-sky-600">

                    {{ $day }}

                </button>

            @endforeach

        </div>

    </section>

    {{-- Popular --}}
    <section>

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-3xl font-bold">
                ⭐ Popular Anime
            </h2>

            <a href="#" class="text-sky-400 hover:text-sky-300">
                View More →
            </a>

        </div>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">

            @foreach($popular as $anime)

                <x-anime-card
                    :id="$anime['id']"
                    :image="$anime['coverImage']['extraLarge']"
                    :title="$anime['title']['english'] ?: $anime['title']['romaji']"
                    :episode="'⭐ '.$anime['averageScore']"
                />

            @endforeach

        </div>

    </section>

</div>

@endsection