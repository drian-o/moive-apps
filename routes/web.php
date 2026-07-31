<?php

use Illuminate\Support\Facades\Route;

use Spatie\Dns\Dns;
use App\Models\User;
use App\Services\Apify\ApifyService;
use App\Http\Controllers\Admin\AIController;
use App\Services\NekopoiService;
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
use App\Http\Controllers\HentaiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdsController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\GoogleIndexingController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SeoToolsController;
use App\Services\NawalaService;
use App\Http\Controllers\Admin\TerminalController;
use App\Http\Controllers\Admin\RawPasteController;
use App\Http\Controllers\RawPastePublicController;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [
        AuthController::class,
        'showLoginForm',
    ])->name('admin.login');

    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('admin.login.submit');


    /*
    |--------------------------------------------------------------------------
    | Authenticated
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            DashboardController::class,
            'index',
        ])->name('admin.dashboard');

        Route::post('/logout', [
            AuthController::class,
            'logout',
        ])->name('admin.logout');


        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            SettingController::class,
            'index',
        ])->name('admin.settings');

        Route::post('/settings', [
            SettingController::class,
            'update',
        ])->name('admin.settings.update');


        /*
        |--------------------------------------------------------------------------
        | Ads
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'ads',
            AdsController::class
        )->names('admin.ads');


        /*
        |--------------------------------------------------------------------------
        | Google Indexing
        |--------------------------------------------------------------------------
        */

        Route::get('/google-indexing', [
            GoogleIndexingController::class,
            'index',
        ])->name('admin.google-indexing');

        Route::post('/google-indexing/upload', [
            GoogleIndexingController::class,
            'upload',
        ])->name('admin.google-indexing.upload');

        Route::post('/google-indexing/test', [
            GoogleIndexingController::class,
            'test',
        ])->name('admin.google-indexing.test');

        Route::delete('/google-indexing/delete', [
            GoogleIndexingController::class,
            'delete',
        ])->name('admin.google-indexing.delete');

        Route::post('/google-indexing/submit', [
            GoogleIndexingController::class,
            'submit',
        ])->name('admin.google-indexing.submit');


        /*
        |--------------------------------------------------------------------------
        | SEO Tools
        |--------------------------------------------------------------------------
        */

        Route::prefix('seo-tools')
            ->name('admin.seo-tools.')
            ->group(function () {

                Route::get('/', [
                    SeoToolsController::class,
                    'index',
                ])->name('index');

                Route::post('/analyze', [
                    SeoToolsController::class,
                    'analyze',
                ])->name('analyze');

                Route::post('/audit', [
                    SeoToolsController::class,
                    'audit',
                ])->name('audit');

                Route::post('/backlinks', [
                    SeoToolsController::class,
                    'backlinks',
                ])->name('backlinks');

                Route::post('/scan', [
                    SeoToolsController::class,
                    'scan',
                ])->name('scan');


                /*
                |--------------------------------------------------------------------------
                | Authority Checker
                |--------------------------------------------------------------------------
                */

                Route::get('/authority-checker', [
                    SeoToolsController::class,
                    'authority',
                ])->name('authority');

                Route::post('/authority-checker', [
                    SeoToolsController::class,
                    'authorityCheck',
                ])->name('authority.check');


                /*
                |--------------------------------------------------------------------------
                | Shortlinks
                |--------------------------------------------------------------------------
                */

                Route::get('/shortlinks', [
                    SeoToolsController::class,
                    'shortlinks',
                ])->name('shortlinks');

                Route::get('/shortlinks/list', [
                    SeoToolsController::class,
                    'shortlinksList',
                ])->name('shortlinks.list');

                Route::get('/shortlinks/options', [
                    SeoToolsController::class,
                    'shortlinksOptions',
                ])->name('shortlinks.options');

                Route::post('/shortlinks', [
                    SeoToolsController::class,
                    'createShortlink',
                ])->name('shortlinks.store');

                Route::get('/shortlinks/{id}', [
                    SeoToolsController::class,
                    'shortlinkDetail',
                ])->name('shortlinks.detail');

                Route::put('/shortlinks/{id}', [
                    SeoToolsController::class,
                    'updateShortlink',
                ])->name('shortlinks.update');

                Route::delete('/shortlinks/{id}', [
                    SeoToolsController::class,
                    'deleteShortlink',
                ])->name('shortlinks.delete');


                /*
                |--------------------------------------------------------------------------
                | Links
                |--------------------------------------------------------------------------
                */

                Route::get('/links', [
                    SeoToolsController::class,
                    'links',
                ])->name('links');

                Route::get('/links/list', [
                    SeoToolsController::class,
                    'linksList',
                ])->name('links.list');

                Route::post('/links', [
                    SeoToolsController::class,
                    'createLink',
                ])->name('links.store');

                Route::get('/links/{id}', [
                    SeoToolsController::class,
                    'linkDetail',
                ])->name('links.detail');

                Route::put('/links/{id}', [
                    SeoToolsController::class,
                    'updateLink',
                ])->name('links.update');

                Route::delete('/links/{id}', [
                    SeoToolsController::class,
                    'deleteLink',
                ])->name('links.delete');


                /*
                |--------------------------------------------------------------------------
                | Analytics
                |--------------------------------------------------------------------------
                */

                Route::get('/analytics', [
                    SeoToolsController::class,
                    'analytics',
                ])->name('analytics');

                Route::get('/analytics/data', [
                    SeoToolsController::class,
                    'analyticsData',
                ])->name('analytics.data');

                Route::get('/analytics/data/{id}', [
                    SeoToolsController::class,
                    'analyticsDetail',
                ])
                    ->whereNumber('id')
                    ->name('analytics.detail');


                /*
                |--------------------------------------------------------------------------
                | Terminal
                |--------------------------------------------------------------------------
                */

                Route::get('/terminal', [
                    TerminalController::class,
                    'index',
                ])->name('terminal.index');

            }); // END SEO TOOLS


                /*
        |--------------------------------------------------------------------------
        | Raw Online
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/raw-online/{rawPaste}/extractor',
            [
                RawPasteController::class,
                'extractor',
            ]
        )->name('admin.raw-online.extractor');

        Route::resource(
            'raw-online',
            RawPasteController::class
        )
            ->parameters([
                'raw-online' => 'rawPaste',
            ])
            ->except(['show'])
            ->names('admin.raw-online');


        /*
        |--------------------------------------------------------------------------
        | AI Assistant
        |--------------------------------------------------------------------------
        */

        Route::prefix('ai')
            ->name('admin.ai.')
            ->group(function () {

                Route::get('/', [
                    AIController::class,
                    'index',
                ])->name('index');

                Route::post('/chat', [
                    AIController::class,
                    'chat',
                ])->name('chat');

            });


        /*
        |--------------------------------------------------------------------------
        | Articles
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'articles',
            ArticleController::class
        )->names('admin.articles');

    }); // END AUTH

}); // END ADMIN
    

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles', [HomeController::class, 'articles'])
    ->name('articles.index');

Route::get('/articles/{slug}', [HomeController::class, 'article'])
    ->name('articles.show');

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

// ======================================================
// HENTAI
// ======================================================

Route::prefix('hentai')->name('hentai.')->group(function () {

    Route::get('/', [HentaiController::class, 'index'])
        ->name('index');

    Route::get('/search', [HentaiController::class, 'search'])
        ->name('search');

    Route::get('/genres', [HentaiController::class, 'genres'])
        ->name('genres');

    Route::get('/genre/{slug}', [HentaiController::class, 'genre'])
        ->name('genre');

    Route::get('/category/{slug}', [HentaiController::class, 'category'])
        ->name('category');

    Route::get('/latest', [HentaiController::class, 'latest'])
        ->name('latest');

    Route::get('/jav', [HentaiController::class, 'jav'])
        ->name('jav');

    Route::get('/{slug}', [HentaiController::class, 'show'])
        ->name('show');

    Route::get('/episode/{slug}', [HentaiController::class, 'episode'])
        ->name('episode');
        
    
});

/*
|--------------------------------------------------------------------------
| IMAGE PROXY
|--------------------------------------------------------------------------
*/

Route::get('/proxy/image', function (Request $request) {

    $url = $request->query('url');

    abort_if(empty($url), 404);

    $host = parse_url($url, PHP_URL_HOST);

    abort_unless(
        in_array($host, [
            'nekopoi.care',
            'www.nekopoi.care',
        ]),
        403
    );

    $response = Http::withHeaders([
        'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'Accept'          => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Referer'         => 'https://nekopoi.care/',
        'Origin'          => 'https://nekopoi.care',
    ])
    ->timeout(30)
    ->get($url);

    abort_if($response->failed(), 404);

    return response($response->body(), 200)
        ->header(
            'Content-Type',
            $response->header('Content-Type') ?? 'image/jpeg'
        )
        ->header('Cache-Control', 'public, max-age=86400');

})->name('image.proxy');



/*
|--------------------------------------------------------------------------
| Raw Online Public
|--------------------------------------------------------------------------
*/

Route::get(
    '/p/{rawPaste:slug}',
    [RawPastePublicController::class, 'show']
)->name('raw-online.show');

Route::get(
    '/raw/{rawPaste:slug}/download',
    [RawPastePublicController::class, 'download']
)->name('raw-online.download');

Route::get(
    '/raw/{rawPaste:slug}',
    [RawPastePublicController::class, 'raw']
)->name('raw-online.raw');