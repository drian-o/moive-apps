<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NawalaService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.nawala.base_url'), '/');
        $this->apiKey = config('services.nawala.api_key');
    }

    protected function client()
    {
        return Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
            'Accept' => 'application/json',
        ]);
    }

    public function checkDomains(array|string $domains)
    {
        if (is_array($domains)) {
            $domains = implode(',', $domains);
        }

        return $this->client()
            ->post($this->baseUrl . '/public-check-domain', [
                'domain' => $domains,
            ])
            ->throw()
            ->json();
    }

    public function getShortlinks()
    {
        return $this->client()
            ->get($this->baseUrl . '/user-api/shortlinks')
            ->throw()
            ->json();
    }

    public function analytics(?string $shortlinkId = null)
    {
        $url = $this->baseUrl . '/user-api/analytics';

        if ($shortlinkId) {
            $url .= '/' . $shortlinkId;
        }

        return $this->client()
            ->get($url)
            ->throw()
            ->json();
    }
    /*
    |--------------------------------------------------------------------------
    | SHORTLINK
    |--------------------------------------------------------------------------
    */

    public function shortlinks()
    {
        return $this->client()
            ->get($this->baseUrl.'/user-api/shortlinks')
            ->json();
    }

    public function shortlink($id)
    {
        return $this->client()
            ->get($this->baseUrl."/user-api/shortlinks/{$id}")
            ->json();
    }

    public function createShortlink(array $data)
    {
        return $this->client()
            ->post($this->baseUrl.'/user-api/shortlinks',$data)
            ->json();
    }

    public function updateShortlink($id,array $data)
    {
        return $this->client()
            ->put($this->baseUrl."/user-api/shortlinks/{$id}",$data)
            ->json();
    }

    public function deleteShortlink($id)
    {
        return $this->client()
            ->delete($this->baseUrl."/user-api/shortlinks/{$id}")
            ->json();
    }

    /*
    |--------------------------------------------------------------------------
    | LINKS
    |--------------------------------------------------------------------------
    */

    public function createLink(array $data)
    {
        return $this->client()
            ->post($this->baseUrl.'/user-api/links',$data)
            ->json();
    }

    public function deleteLink($id)
    {
        return $this->client()
            ->delete($this->baseUrl."/user-api/links/{$id}")
            ->json();
    }

public function getLinks(array $params = [])
{
    return $this->client()
        ->get($this->baseUrl . '/user-api/links', $params)
        ->throw()
        ->json();
}
public function link(string $id)
{
    return $this->client()
        ->get($this->baseUrl . "/user-api/links/{$id}")
        ->throw()
        ->json();
}

public function updateLink(string $id, array $data)
{
    return $this->client()
        ->put($this->baseUrl . "/user-api/links/{$id}", $data)
        ->throw()
        ->json();
}
}
