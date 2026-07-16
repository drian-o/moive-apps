<?php

namespace App\Http\Controllers;

use App\Services\SansekaiAnimeService;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function __construct(
        protected SansekaiAnimeService $anime
    ) {}

    public function index()
    {
        return redirect('/');
    }

    public function show($id)
    {
        $result = $this->anime->detail($id);

        if (empty($result) || empty($result['data'])) {
            abort(404);
        }

        return view('pages.anime.show', [
            'anime' => $result['data'],
        ]);
    }

    public function search(Request $request)
    {
        $keyword = trim($request->q);

        $result = $this->anime->search($keyword);

        return view('pages.anime.search', [
            'keyword' => $keyword,
            'results' => $result['data']['animeList'] ?? [],
        ]);
    }

    public function searchApi(Request $request)
    {
        return response()->json(
            $this->anime->search($request->q)
        );
    }

    public function genres()
    {
        $result = $this->anime->genres();

        return view('pages.anime.genres', [
            'genres' => $result['data']['genreList'] ?? [],
        ]);
    }

    public function genre($genre)
    {
        $result = $this->anime->genre($genre);

        return view('pages.anime.genre', [
            'genre' => $genre,
            'results' => $result['data']['animeList'] ?? [],
        ]);
    }

    public function unlimited()
    {
        $result = $this->anime->unlimited();

        return view('pages.anime.unlimited', [
            'list' => $result['data']['list'] ?? [],
        ]);
    }

    public function letter($letter)
    {
        return view('pages.anime.letter', [
            'letter' => strtoupper($letter),
            'results' => $this->anime->unlimitedByLetter($letter),
        ]);
    }
}