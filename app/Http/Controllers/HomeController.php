<?php

namespace App\Http\Controllers;

use App\Services\SansekaiAnimeService;
use App\Services\SansekaiDonghuaService;
use App\Services\MangasusukuService;

class HomeController extends Controller
{
    public function index(
        SansekaiAnimeService $anime,
        SansekaiDonghuaService $donghua,
        MangasusukuService $manga
    ) {

        $animeHome = $anime->home();
        $donghuaHome = $donghua->home();
        $mangaHome = $manga->home();

        return view('home', [

            // ======================
            // Anime
            // ======================

            'ongoingAnime' => $animeHome['data']['ongoing']['animeList'] ?? [],
            'completedAnime' => $animeHome['data']['completed']['animeList'] ?? [],

            // ======================
            // Donghua
            // ======================

            'latestDonghua' => $donghuaHome['latest_release'] ?? [],
            'completedDonghua' => $donghuaHome['completed_donghua'] ?? [],

            // ======================
            // Manga
            // ======================

            'latestManga' => $mangaHome['latestUpdates'] ?? [],
            'popularManga' => $mangaHome['popularToday'] ?? [],
            'hotManga' => $mangaHome['hotComics'] ?? [],

        ]);
    }
}