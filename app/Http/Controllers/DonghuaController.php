<?php

namespace App\Http\Controllers;

use App\Services\SansekaiDonghuaService;
use Illuminate\Http\Request;

class DonghuaController extends Controller
{
    public function __construct(
        protected SansekaiDonghuaService $donghua
    ) {}

    /**
     * Home
     */
public function index($page = 1)
{
    $result = $this->donghua->home($page);

    return view('pages.donghua.home', [
        'latest' => $result['latest_release'] ?? [],
        'completed' => $result['completed_donghua'] ?? [],
    ]);
}

    /**
     * Ongoing
     */
    public function ongoing($page = 1)
    {
        $result = $this->donghua->ongoing($page);

        return view('pages.donghua.ongoing', [
            'result' => $result['data'] ?? [],
        ]);
    }

    /**
     * Completed
     */
    public function completed($page = 1)
    {
        $result = $this->donghua->completed($page);

        return view('pages.donghua.completed', [
            'result' => $result['data'] ?? [],
        ]);
    }

    /**
     * Latest
     */
public function latest($page = 1)
{
    $result = $this->donghua->latest($page);

    return view('pages.donghua.latest', [
        'results' => $result['latest_donghua'] ?? [],
    ]);
}
    /**
     * Schedule
     */
    public function schedule()
    {
        $result = $this->donghua->schedule();

        return view('pages.donghua.schedule', [
            'result' => $result['data'] ?? [],
        ]);
    }

    /**
     * Search
     */
    public function search(Request $request)
    {
        $keyword = trim($request->q);

        $result = $this->donghua->search($keyword);

        return view('pages.donghua.search', [
            'keyword' => $keyword,
            'results' => $result['data'] ?? [],
        ]);
    }

    /**
     * Search API (Ajax)
     */
    public function searchApi(Request $request)
    {
        return response()->json(
            $this->donghua->search($request->q)
        );
    }

    /**
     * Detail
     */
public function show($slug)
{
    // Kalau slug bukan episode, langsung ambil detail
    if (!str_contains($slug, '-episode-')) {

        $donghua = $this->donghua->detail($slug);

        if (empty($donghua)) {
            abort(404);
        }

        return view('pages.donghua.show', [
            'donghua' => $donghua,
        ]);
    }

    // Kalau slug episode
    $episode = $this->donghua->episode(rtrim($slug, '/'));

    if (empty($episode)) {
        abort(404);
    }

    $seriesSlug = $episode['donghua_details']['slug'] ?? null;

    if (empty($seriesSlug)) {
        abort(404);
    }

    $donghua = $this->donghua->detail($seriesSlug);

    if (empty($donghua)) {
        abort(404);
    }

    return view('pages.donghua.show', [
        'donghua' => $donghua,
    ]);
}
    /**
     * Watch Episode
     */
public function episode($slug)
{
    $episode = $this->donghua->episode(rtrim($slug, '/'));

    if (empty($episode)) {
        abort(404);
    }

    return view('pages.donghua.watch', [
        'episode' => $episode,
    ]);
}
    /**
     * Genres
     */
public function genres()
{
    $result = $this->donghua->genres();

    return view('pages.donghua.genres', [
        'genres' => $result['data'] ?? [],
    ]);
}

    /**
     * Genre Detail
     */
    public function genre($genre, $page = 1)
    {
        $result = $this->donghua->genre($genre, $page);

        return view('pages.donghua.genre', [
            'genre' => $genre,
            'results' => $result['data'] ?? [],
        ]);
    }

    /**
     * A-Z
     */
    public function az($letter, $page = 1)
    {
        $result = $this->donghua->az($letter, $page);

        return view('pages.donghua.az', [
            'letter' => strtoupper($letter),
            'results' => $result['data'] ?? [],
        ]);
    }

    /**
     * Season
     */
    public function season($year)
    {
        $result = $this->donghua->seasons($year);

        return view('pages.donghua.season', [
            'year' => $year,
            'results' => $result['data'] ?? [],
        ]);
    }
}