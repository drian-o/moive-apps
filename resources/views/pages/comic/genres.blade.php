@extends('layouts.app')

@section('title', 'Daftar Genre')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4">

        🏷 Daftar Genre Manga

    </h2>

    <div class="row">

        @forelse($genres['genres'] ?? [] as $genre)

            <div class="col-6 col-md-3 col-lg-2 mb-3">

                <a href="{{ route('comic.genre', $genre['slug']) }}"
                   class="btn btn-outline-primary w-100">

                    {{ $genre['name'] }}

                </a>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning">

                    Genre tidak ditemukan.

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection