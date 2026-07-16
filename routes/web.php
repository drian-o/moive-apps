<?php

use Illuminate\Support\Facades\Route;

use Spatie\Dns\Dns;
use App\Models\User;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\DonghuaController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ReadController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CheckerController;


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');

    Route::middleware('auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');
        Route::get('/settings', [SettingController::class, 'index'])
        ->name('admin.settings');
         Route::post('/settings', [SettingController::class, 'update'])
        ->name('admin.settings.update');
            Route::get('/checker', [CheckerController::class, 'index'])
        ->name('admin.checker');

        Route::post('/checker/check', [CheckerController::class, 'check'])
        ->name('admin.checker.check');

    });

});

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ======================================================
// ANIME
// ======================================================

Route::prefix('anime')->name('anime.')->group(function () {

    Route::get('/', [AnimeController::class, 'index'])->name('index');

    Route::get('/search', [AnimeController::class, 'search'])->name('search');

    Route::get('/api/search', [AnimeController::class, 'searchApi'])->name('api.search');

    Route::get('/genres', [AnimeController::class, 'genres'])->name('genres');

    Route::get('/genres/{genre}', [AnimeController::class, 'genre'])->name('genre');

    Route::get('/unlimited', [AnimeController::class, 'unlimited'])->name('unlimited');

    Route::get('/unlimited/{letter}', [AnimeController::class, 'letter'])->name('letter');

    Route::get('/{id}', [AnimeController::class, 'show'])->name('show');

});

Route::get('/anime-api/search', [AnimeController::class, 'searchApi'])
    ->name('anime.api.search');

Route::get('/watch/{episode}', [WatchController::class, 'show'])
    ->name('watch');

// ======================================================
// DONGHUA
// ======================================================

Route::prefix('donghua')->name('donghua.')->group(function () {

    Route::get('/', [DonghuaController::class, 'index'])->name('home');

    Route::get('/ongoing/{page?}', [DonghuaController::class, 'ongoing'])->name('ongoing');

    Route::get('/completed/{page?}', [DonghuaController::class, 'completed'])->name('completed');

    Route::get('/latest/{page?}', [DonghuaController::class, 'latest'])->name('latest');

    Route::get('/schedule', [DonghuaController::class, 'schedule'])->name('schedule');

    Route::get('/search', [DonghuaController::class, 'search'])->name('search');

    Route::get('/api/search', [DonghuaController::class, 'searchApi'])->name('api.search');

    Route::get('/genres', [DonghuaController::class, 'genres'])->name('genres');

    Route::get('/genres/{genre}/{page?}', [DonghuaController::class, 'genre'])->name('genre');

    Route::get('/az/{letter}/{page?}', [DonghuaController::class, 'az'])->name('az');

    Route::get('/season/{year}', [DonghuaController::class, 'season'])->name('season');

    Route::get('/watch/{slug}', [DonghuaController::class, 'episode'])->name('watch');

    Route::get('/{slug}', [DonghuaController::class, 'show'])->name('show');

});

// ======================================================
// COMIC
// ======================================================

Route::prefix('comic')->group(function () {

    Route::get('/', [ComicController::class, 'index'])->name('comic.index');

    Route::get('/terbaru/{page?}', [ComicController::class, 'terbaru'])->name('comic.terbaru');

    Route::get('/populer/{page?}', [ComicController::class, 'populer'])->name('comic.populer');

    Route::get('/list/{page?}', [ComicController::class, 'list'])->name('comic.list');

    Route::get('/list-by-char/{char}/{page?}', [ComicController::class, 'listByChar'])->name('comic.list.char');

    Route::get('/genres', [ComicController::class, 'genres'])->name('comic.genres');

    Route::get('/genre/{genreId}/{page?}', [ComicController::class, 'genre'])->name('comic.genre');

    Route::get('/search', [ComicController::class, 'search'])->name('comic.search');

    Route::get('/{slug}', [ComicController::class, 'show'])->name('comic.show');

    Route::get('/chapter/{segment}', [ComicController::class, 'chapter'])
        ->where('segment', '.*')
        ->name('comic.chapter');

});

Route::get('/debug-nawala', function () {

    $records = Dns::query()
        ->useNameserver('180.131.144.144')
        ->setTimeout(3)
        ->getRecords('rtp-mmtoto.online');

    dd($records);

});