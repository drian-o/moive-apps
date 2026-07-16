@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px]">

    <div class="mb-8">

        <h1 class="text-3xl font-bold">
            Latest Donghua
        </h1>

    </div>

    <div class="grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6">

        @foreach($results as $anime)

            <x-anime-card
                :id="$anime['slug']"
                :image="$anime['poster']"
                :title="$anime['title']"
                :episode="$anime['status']"
            />

        @endforeach

    </div>

</div>

@endsection