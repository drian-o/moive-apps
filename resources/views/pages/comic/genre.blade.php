@extends('layouts.app')

@section('title', 'Genre Manga')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4">

        🏷 Genre #{{ $genre['genreId'] }}

    </h2>

    <div class="row">

        @forelse($genre['mangaList'] ?? [] as $comic)

            <div class="col-6 col-md-4 col-lg-2 mb-4">

                <a href="{{ route('comic.show', $comic['slug']) }}"
                   class="text-decoration-none">

                    <div class="card border-0 shadow h-100">

                        <img
                            src="{{ $comic['image'] }}"
                            class="card-img-top"
                            style="height:260px;object-fit:cover;">

                        <div class="card-body">

                            <h6
                                class="fw-bold text-dark"
                                style="height:45px;overflow:hidden;">

                                {{ $comic['title'] }}

                            </h6>

                            <span class="badge bg-primary">

                                {{ $comic['chapter'] }}

                            </span>

                            <div class="mt-2">

                                ⭐ {{ $comic['rating'] }}

                            </div>

                            @if(!empty($comic['status']))

                                <div class="mt-1">

                                    <span class="badge bg-success">

                                        {{ $comic['status'] }}

                                    </span>

                                </div>

                            @endif

                            @if(!empty($comic['isHot']))

                                <div class="mt-1">

                                    <span class="badge bg-danger">

                                        HOT

                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning">

                    Tidak ada manga pada genre ini.

                </div>

            </div>

        @endforelse

    </div>

    @if($genre['pagination']['hasNextPage'])

        <div class="text-center mt-4">

            <a
                href="{{ route('comic.genre', [
                    'genreId' => $genre['genreId'],
                    'page' => $genre['pagination']['nextPage']
                ]) }}"
                class="btn btn-primary">

                Next Page

            </a>

        </div>

    @endif

</div>

@endsection