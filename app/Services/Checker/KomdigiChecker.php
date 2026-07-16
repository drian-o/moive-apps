<?php

namespace App\Services\Checker;

use Illuminate\Support\Facades\Http;

class KomdigiChecker
{
    public function check(string $domain): array
    {
        try {

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'text/html',
            ])
            ->timeout(30)
            ->get('https://trustpositif.komdigi.go.id/');

            return [

                'domain' => $domain,

                'status_code' => $response->status(),

                'headers' => $response->headers(),

                'body' => substr($response->body(), 0, 2000),

            ];

        } catch (\Throwable $e) {

            return [

                'domain' => $domain,

                'status' => 'error',

                'message' => $e->getMessage(),

            ];

        }
    }
}