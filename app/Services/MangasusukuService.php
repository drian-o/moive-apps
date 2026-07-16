<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MangasusukuService
{
    protected string $baseUrl = 'https://www.sankavollerei.web.id/comic';

    protected function request($url)
    {
        return Http::timeout(30)
            ->acceptJson()
            ->get($this->baseUrl.$url)
            ->throw()
            ->json();
    }

    public function home($page = 1)
    {
        return $this->request("/mangasusuku/home/{$page}");
    }
    public function latest($page = 1)
    {
        return $this->request("/mangasusuku/latest/{$page}");
    }
    public function popular($page = 1)
    {
        return $this->request("/mangasusuku/popular/{$page}");
    }
    public function list($page = 1)
    {
        return $this->request("/mangasusuku/list/{$page}");
    }
    public function listByChar($char, $page = 1)
    {
        return $this->request("/mangasusuku/list-by-char/{$char}/{$page}");
    }
    public function genres()
{
    return $this->request('/mangasusuku/genres');
}
public function genre($genreId, $page = 1)
{
    return $this->request("/mangasusuku/genre/{$genreId}/{$page}");
}
public function detail($slug)
{
    return $this->request("/mangasusuku/detail/{$slug}");
}
public function chapter($slug)
{
    $slug = trim($slug, '/');

    return $this->request("/mangasusuku/chapter/{$slug}");
}
}