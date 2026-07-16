<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SansekaiDonghuaService
{
    protected string $baseUrl = 'https://www.sankavollerei.web.id';

    protected function request(string $endpoint)
    {
        $response = Http::timeout(30)
            ->acceptJson()
            ->get($this->baseUrl . $endpoint);

        if (!$response->successful()) {
            return null;
        }

        return $response->json();
    }

    public function home($page = 1)
    {
        return $this->request("/anime/donghua/home/{$page}");
    }

    public function ongoing($page = 1)
    {
        return $this->request("/anime/donghua/ongoing/{$page}");
    }

    public function completed($page = 1)
    {
        return $this->request("/anime/donghua/completed/{$page}");
    }

    public function latest($page = 1)
    {
        return $this->request("/anime/donghua/latest/{$page}");
    }

    public function schedule()
    {
        return $this->request("/anime/donghua/schedule");
    }

    public function search($keyword, $page = 1)
    {
        return $this->request("/anime/donghua/search/" . urlencode($keyword) . "/{$page}");
    }

public function detail($slug)
{
    return $this->request("/anime/donghua/detail/{$slug}");
}

    public function episode($slug)
    {
        return $this->request("/anime/donghua/episode/{$slug}");
    }

    public function genres()
    {
        return $this->request("/anime/donghua/genres");
    }

    public function genre($slug, $page = 1)
    {
        return $this->request("/anime/donghua/genres/{$slug}/{$page}");
    }

    public function seasons($year)
    {
        return $this->request("/anime/donghua/seasons/{$year}");
    }

    public function az($letter, $page = 1)
    {
        return $this->request("/anime/donghua/az-list/{$letter}/{$page}");
    }
}