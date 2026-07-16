<?php

namespace App\Http\Controllers;

use App\Services\SansekaiAnimeService;

class WatchController extends Controller
{
    public function __construct(
        protected SansekaiAnimeService $anime
    ) {}

    public function show($episodeId)
    {
        $response = $this->anime->episode($episodeId);

        if (
            empty($response) ||
            empty($response['data'])
        ) {
            abort(404);
        }

        $episode = $response['data'];

        // ==========================
        // Ambil Detail Anime
        // ==========================
        $detail = $this->anime->detail($episode['animeId']);

        // ==========================
        // Default Server (480p)
        // ==========================
        $serverId = null;

        foreach ($episode['server']['qualities'] as $quality) {

            if ($quality['title'] === '480p') {

                $serverId = $quality['serverList'][0]['serverId'] ?? null;
                break;
            }
        }

        if (!$serverId) {

            $serverId =
                $episode['server']['qualities'][0]['serverList'][0]['serverId']
                ?? null;
        }

        $player = null;

        if ($serverId) {

            $server = $this->anime->server($serverId);

            $player = $server['data']['url'] ?? null;
        }

        // ==========================
        // Episode List
        // ==========================
        $episodes = [];

        foreach ($episode['info']['episodeList'] ?? [] as $ep) {

            $episodes[] = [

                'title' => $ep['title'],

                'url' => route('watch', $ep['episodeId']),

            ];
        }

        return view('pages.watch', [

            'watch' => [

                'title' => $episode['title'],

                'subtitle' => $detail['data']['title'] ?? '',

                'poster' => $detail['data']['poster'] ?? null,

                'player' => $player,

                'release' => $episode['releaseTime'] ?? null,

                'servers' => $episode['server']['qualities'] ?? [],

                'episodes' => $episodes,

                'downloads' => $episode['downloadUrl']['qualities'] ?? [],

            ],

        ]);
    }
}