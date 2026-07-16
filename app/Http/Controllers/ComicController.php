<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MangasusukuService;

class ComicController extends Controller
{
    public function __construct(
        protected MangasusukuService $mangasusuku
    ) {}

    public function index()
    {
        $homepage = $this->mangasusuku->home();

        return view('pages.comic.index', compact('homepage'));
    }

    public function terbaru($page = 1)
    {
        $latest = $this->mangasusuku->latest($page);

        return view('pages.comic.terbaru', compact('latest'));
    }

    public function populer($page = 1)
    {
        $popular = $this->mangasusuku->popular($page);

        return view('pages.comic.populer', compact('popular'));
    }

    public function list($page = 1)
    {
        $list = $this->mangasusuku->list($page);

        return view('pages.comic.list', compact('list'));
    }

    public function listByChar($char, $page = 1)
    {
        $list = $this->mangasusuku->listByChar($char, $page);

        return view('pages.comic.list-char', compact('list'));
    }

    public function genres()
    {
        $genres = $this->mangasusuku->genres();

        return view('pages.comic.genres', compact('genres'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return view('pages.comic.search', [
                'search' => null,
                'query' => ''
            ]);
        }

        $search = $this->mangasusuku->search($query);

        return view('pages.comic.search', compact('search', 'query'));
    }
    public function genre($genreId, $page = 1)
{
    $genre = $this->mangasusuku->genre($genreId, $page);

    return view('pages.comic.genre', compact('genre'));
}
public function show($slug)
{
    $comic = $this->mangasusuku->detail($slug);

    abort_if(empty($comic) || empty($comic['success']), 404);

    return view('pages.comic.show', compact('comic'));
}
public function chapter($segment)
{
    $chapter = $this->mangasusuku->chapter($segment);

    abort_if(
        empty($chapter) ||
        empty($chapter['success']),
        404
    );

    return view('pages.comic.read', compact('chapter'));
}
}