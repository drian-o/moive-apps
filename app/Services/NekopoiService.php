<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NekopoiService
{
    public function index(NekopoiService $api)
{
    $result = $api->home();

    dd($result);
}
    protected string $baseUrl = 'https://www.sankavollerei.web.id/anime/nekopoi';

    private function request(string $endpoint): array
    {
        $response = Http::withHeaders([
            'Accept'     => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
            'Referer'    => 'https://www.sankavollerei.web.id/',
        ])
        ->timeout(30)
        ->get($this->baseUrl . '/' . ltrim($endpoint, '/'));

        if ($response->failed()) {
            throw new \Exception(
                'Nekopoi API Error : ' .
                $response->status() .
                "\n" .
                $response->body()
            );
        }

        return $response->json();
    }

    /*
    |--------------------------------------------------------------------------
    | Home
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        return Cache::remember('nekopoi.home', 300, function () {
            return $this->request('home');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function search(string $query)
    {
        return $this->request(
            'search?q=' . urlencode($query)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Hentai List
    |--------------------------------------------------------------------------
    */

    public function hentaiList(int $page = 1)
    {
        return $this->request(
            "hentai-list?page={$page}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Genres
    |--------------------------------------------------------------------------
    */

    public function genres()
    {
        return $this->request('genres');
    }

    /*
    |--------------------------------------------------------------------------
    | Genre
    |--------------------------------------------------------------------------
    */

    public function genre(string $slug, int $page = 1)
    {
        return $this->request(
            "genre/{$slug}?page={$page}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category(string $slug, int $page = 1)
    {
        return $this->request(
            "category/{$slug}?page={$page}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Latest Hentai
    |--------------------------------------------------------------------------
    */

    public function latestHentai(int $page = 1)
    {
        return $this->request(
            "latest-hentai?page={$page}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Latest JAV
    |--------------------------------------------------------------------------
    */

    public function latestJav(int $page = 1)
    {
        return $this->request(
            "latest-jav?page={$page}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Hentai
    |--------------------------------------------------------------------------
    */

    public function detail(string $slug)
    {
        return $this->request(
            "detail/{$slug}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Episode
    |--------------------------------------------------------------------------
    */

    public function episode(string $slug)
    {
        return $this->request(
            "episode/{$slug}"
        );
    }
}