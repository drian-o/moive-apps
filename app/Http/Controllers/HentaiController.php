<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Services\NekopoiService;
use Illuminate\Http\Request;

class HentaiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home
    |--------------------------------------------------------------------------
    */

public function index(NekopoiService $api)
{
    $result = $api->home();

    return view('pages.hentai.index', [
        'recommended'    => $result['data']['recommended'] ?? [],
        'latestHentai'   => $result['data']['latest_hentai'] ?? [],
        'latestEpisodes' => $result['data']['latest_episodes'] ?? [],
        'latestJav'      => $result['data']['latest_jav'] ?? [],
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function search(Request $request, NekopoiService $api)
    {
        $keyword = $request->get('q');

        $result = empty($keyword)
            ? ['data' => []]
            : $api->search($keyword);

        return view('pages.hentai.search', [
            'keyword' => $keyword,
            'results' => $result['data'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Genres
    |--------------------------------------------------------------------------
    */

    public function genres(NekopoiService $api)
    {
        $result = $api->genres();

        return view('pages.hentai.genres', [
            'genres' => $result['data'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Genre
    |--------------------------------------------------------------------------
    */

    public function genre($slug, Request $request, NekopoiService $api)
    {
        $page = $request->integer('page', 1);

        $result = $api->genre($slug, $page);

        return view('pages.hentai.genre', [
            'genre' => $result['data'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category($slug, Request $request, NekopoiService $api)
    {
        $page = $request->integer('page', 1);

        $result = $api->category($slug, $page);

        return view('pages.hentai.category', [
            'category' => $result['data'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Latest Hentai
    |--------------------------------------------------------------------------
    */

    public function latest(Request $request, NekopoiService $api)
    {
        $page = $request->integer('page', 1);

        $result = $api->latestHentai($page);

        return view('pages.hentai.latest', [
            'latest' => $result['data'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Latest JAV
    |--------------------------------------------------------------------------
    */

    public function jav(Request $request, NekopoiService $api)
    {
        $page = $request->integer('page', 1);

        $result = $api->latestJav($page);

        return view('pages.hentai.jav', [
            'jav' => $result['data'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

public function show($slug, NekopoiService $api)
{
    $detail = $api->detail($slug);

    $ads = Ads::where('is_active', 1)
        ->whereIn('position', [
            'player',
            'sidebar',
            'footer',
            'popup',
            'floating',
        ])
        ->get()
        ->keyBy('position');

    return view('pages.hentai.show', [
        'episode'    => $detail['data'] ?? [],

        'playerAd'   => $ads['player'] ?? null,
        'sidebarAd'  => $ads['sidebar'] ?? null,
        'footerAd'   => $ads['footer'] ?? null,
        'popupAd'    => $ads['popup'] ?? null,
        'floatingAd' => $ads['floating'] ?? null,
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | Episode
    |--------------------------------------------------------------------------
    */

    public function episode($slug, NekopoiService $api)
    {
        $result = $api->episode($slug);

        $ads = Ads::where('is_active', 1)
            ->whereIn('position', [
                'player',
                'sidebar',
                'footer',
                'popup',
                'floating',
            ])
            ->get()
            ->keyBy('position');

        return view('pages.hentai.episode', [
            'episode'    => $result['data'] ?? [],
            'episodes'   => $result['data']['episodes']
                            ?? $result['episodes']
                            ?? [],

            'playerAd'   => $ads['player'] ?? null,
            'sidebarAd'  => $ads['sidebar'] ?? null,
            'footerAd'   => $ads['footer'] ?? null,
            'popupAd'    => $ads['popup'] ?? null,
            'floatingAd' => $ads['floating'] ?? null,
        ]);
    }
}