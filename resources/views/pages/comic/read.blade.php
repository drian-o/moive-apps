@extends('layouts.app')

@section('title', $chapter['title'])

@section('content')

<div class="container py-4">

    <div class="text-center mb-4">

        <h2 class="fw-bold">

            {{ $chapter['title'] }}

        </h2>

    </div>

    @foreach($chapter['images'] as $image)

        <div class="mb-3 text-center">

            <img
                src="{{ $image }}"
                class="img-fluid rounded shadow">

        </div>

    @endforeach

    <div class="d-flex justify-content-between mt-5">

        @if(!empty($chapter['navigation']['prev']) && $chapter['navigation']['prev'] != '#/prev/')

            @php
                $prev = trim($chapter['navigation']['prev'], '/');
            @endphp

            <a
                href="{{ route('comic.chapter', $prev) }}"
                class="btn btn-outline-primary">

                ← Chapter Sebelumnya

            </a>

        @else

            <span></span>

        @endif

        @if(!empty($chapter['navigation']['next']) && $chapter['navigation']['next'] != '#/next/')

            @php
                $next = trim($chapter['navigation']['next'], '/');
            @endphp

            <a
                href="{{ route('comic.chapter', $next) }}"
                class="btn btn-primary">

                Chapter Berikutnya →

            </a>

        @endif

    </div>

</div>

@endsection