@extends('layouts.app')

@section('title', 'Manga Populer')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4">

        🔥 Manga Populer

    </h2>

    <div class="row">

        @forelse($popular['mangaList'] ?? [] as $comic)

            <div class="col-6 col-md-4 col-lg-2 mb-4">

                <div class="card border-0 shadow h-100">

                    <img
                        src="{{ $comic['image'] }}"
                        class="card-img-top"
                        style="height:260px;object-fit:cover;">

                    <div class="card-body">

                        <h6
                            class="fw-bold"
                            style="height:45px;overflow:hidden;">

                            {{ $comic['title'] }}

                        </h6>

                        <span class="badge bg-danger">

                            {{ $comic['chapter'] }}

                        </span>

                        @if(!empty($comic['rating']))

                            <div class="mt-2">

                                ⭐ {{ $comic['rating'] }}

                            </div>

                        @endif

                        @if(!empty($comic['type']))

                            <div class="mt-1">

                                <small class="text-muted">

                                    {{ $comic['type'] }}

                                </small>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning">

                    Tidak ada manga populer.

                </div>

            </div>

        @endforelse

    </div>

    @if($popular['pagination']['hasNextPage'])

        <div class="text-center mt-4">

            <a
                href="{{ route('comic.populer', $popular['pagination']['nextPage']) }}"
                class="btn btn-primary">

                Next Page

            </a>

        </div>

    @endif

</div>

@endsection