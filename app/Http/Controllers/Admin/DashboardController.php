<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Models\Visitor;
use App\Services\MangasusukuService;
use App\Services\SansekaiAnimeService;
use App\Services\SansekaiDonghuaService;

class DashboardController extends Controller
{
    public function index(
        SansekaiAnimeService $anime,
        SansekaiDonghuaService $donghua,
        MangasusukuService $comic
    ) {

        $animeHome = $anime->home();

        $donghuaHome = $donghua->home();

        $comicHome = $comic->home();

        return view('admin.dashboard.index', [

            // Anime Homepage (15)
            'animeCount' => count($animeHome['data']['ongoing']['animeList'] ?? []),

            // Donghua Homepage (20)
            'donghuaCount' => count($donghuaHome['latest_release'] ?? []),

            // Comic Homepage (16)
            'comicCount' => count($comicHome['latestUpdates'] ?? []),

            // Database
            'userCount' => User::count(),

            'visitorCount' => Visitor::count(),

            'todayVisitor' => Visitor::whereDate('created_at', today())->count(),

            'setting' => Setting::first(),

        ]);
    }
}