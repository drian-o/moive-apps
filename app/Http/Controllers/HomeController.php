<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\MangasusukuService;
use App\Services\NekopoiService;
use App\Services\SansekaiAnimeService;
use App\Services\SansekaiDonghuaService;

class HomeController extends Controller
{
    public function index(
        SansekaiAnimeService $anime,
        SansekaiDonghuaService $donghua,
        MangasusukuService $manga,
        NekopoiService $nekopoi
    ) {
        
        $animeHome   = $anime->home();
        $donghuaHome = $donghua->home();
        $mangaHome   = $manga->home();
        $nekopoiHome = $nekopoi->home();

        $heroAnime = null;

        if (!empty($animeHome['data']['ongoing']['animeList'])) {

            $firstAnime = $animeHome['data']['ongoing']['animeList'][0];

            $detail = $anime->detail($firstAnime['animeId']);

            if (!empty($detail['data'])) {
                $heroAnime = $detail['data'];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recommended Hentai
        |--------------------------------------------------------------------------
        */

        $recommendedHentai = [];

        foreach (($nekopoiHome['data']['recommended'] ?? []) as $item) {

            try {

                $detail = $nekopoi->detail($item['slug']);

                if (($detail['status'] ?? '') === 'success') {
                    $recommendedHentai[] = $detail['data'];
                }

            } catch (\Throwable $e) {

                $recommendedHentai[] = [
                    'title'     => $item['title'],
                    'slug'      => $item['slug'],
                    'thumbnail' => 'https://placehold.co/300x420?text=No+Cover',
                    'score'     => '-',
                    'genres'    => [],
                    'episodes'  => [],
                ];
            }
        }

        return view('home', [

            /*
            |--------------------------------------------------------------------------
            | Anime
            |--------------------------------------------------------------------------
            */

            'heroAnime'      => $heroAnime,
            'ongoingAnime'   => $animeHome['data']['ongoing']['animeList'] ?? [],
            'completedAnime' => $animeHome['data']['completed']['animeList'] ?? [],

            /*
            |--------------------------------------------------------------------------
            | Donghua
            |--------------------------------------------------------------------------
            */

            'latestDonghua'    => $donghuaHome['latest_release'] ?? [],
            'completedDonghua' => $donghuaHome['completed_donghua'] ?? [],

            /*
            |--------------------------------------------------------------------------
            | Manga
            |--------------------------------------------------------------------------
            */

            'latestManga'  => $mangaHome['latestUpdates'] ?? [],
            'popularManga' => $mangaHome['popularToday'] ?? [],
            'hotManga'     => $mangaHome['hotComics'] ?? [],

            /*
            |--------------------------------------------------------------------------
            | Nekopoi
            |--------------------------------------------------------------------------
            */

            'recommendedHentai' => $recommendedHentai,
            'latestHentai'      => $nekopoiHome['data']['latest_hentai'] ?? [],
            'latestEpisodes'    => $nekopoiHome['data']['latest_episodes'] ?? [],
            'latestJav'         => $nekopoiHome['data']['latest_jav'] ?? [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Articles
    |--------------------------------------------------------------------------
    */

    public function articles()
    {
        $articles = Article::where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('pages.articles.index', compact('articles'));
    }

    public function article($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $article->increment('views');

        $related = Article::where('status', 'published')
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('pages.articles.show', compact('article', 'related'));
    }
}