<?php

namespace App\Services\Apify;

use Illuminate\Support\Facades\Http;

class ApifyService
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('apify.token');
        $this->baseUrl = rtrim(config('apify.base_url'), '/');
    }

protected function client()
{
    return Http::withToken($this->token)
        ->acceptJson()
        ->connectTimeout(30)
        ->timeout(300)
        ->retry(2, 1000);
}

    /**
     * Start Actor
     */
    public function runActor(string $actorId, array $input)
    {
        $actorId = str_replace('/', '~', $actorId);

        $response = $this->client()->post(
            "{$this->baseUrl}/acts/{$actorId}/runs",
            $input
        );

        logger()->info([
            'runActor_status' => $response->status(),
            'runActor_body'   => $response->json(),
        ]);

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return $response->json();
    }

    /**
     * Check Status
     */
    public function getRunStatus(string $runId)
    {
        $response = $this->client()->get(
            "{$this->baseUrl}/actor-runs/{$runId}"
        );

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return $response->json('data');
    }

    /**
     * Dataset
     */
    public function getDataset(string $datasetId)
    {
        $response = $this->client()->get(
            "{$this->baseUrl}/datasets/{$datasetId}/items"
        );

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return $response->json();
    }
}