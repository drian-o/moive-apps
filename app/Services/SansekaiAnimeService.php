<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SansekaiAnimeService
{
    protected string $baseUrl = 'https://www.sankavollerei.web.id';

    protected function request(string $endpoint, array $query = [])
    {
        $response = Http::timeout(30)
            ->acceptJson()
            ->get($this->baseUrl . $endpoint, $query);

        if (!$response->successful()) {
            return null;
        }

        return json_decode($response->body(), true);
    }

    public function home()
    {
        return $this->request('/anime/home');
    }

    public function search($query)
    {
        return $this->request('/anime/search/' . urlencode($query));
    }

    public function detail($id)
    {
        return $this->request('/anime/anime/' . $id);
    }

    public function episode($episodeId)
    {
        return $this->request('/anime/episode/' . $episodeId);
    }

    public function server($serverId)
    {
        return $this->request('/anime/server/' . $serverId);
    }

    // ==========================
    // Genre
    // ==========================

    public function genres()
    {
        return $this->request('/anime/samehadaku/genres');
    }

    public function genre($genreId)
    {
        return $this->request('/anime/samehadaku/genres/' . $genreId);
    }

    // ==========================
    // Unlimited
    // ==========================

    public function unlimited()
    {
        return $this->request('/anime/unlimited');
    }

    public function unlimitedByLetter($letter)
    {
        $result = $this->unlimited();

        if (
            empty($result) ||
            empty($result['data']['list'])
        ) {
            return [];
        }

        foreach ($result['data']['list'] as $group) {

            if (strtoupper($group['startWith']) === strtoupper($letter)) {
                return $group['animeList'];
            }

        }

        return [];
    }
}