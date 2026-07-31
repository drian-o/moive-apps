<?php

namespace App\Services;

use App\Models\GoogleIndexingSetting;
use Google\Client;
use Google\Service\Indexing;
use Google\Service\Indexing\UrlNotification;

class GoogleIndexingService
{
    protected ?Client $client = null;
    protected ?Indexing $service = null;

    public function __construct()
    {
        $setting = GoogleIndexingSetting::first();

        if (!$setting || empty($setting->credential)) {
            return;
        }

        $this->client = new Client();

        $this->client->setAuthConfig($setting->credential);

        $this->client->setScopes([
            Indexing::INDEXING
        ]);

        $this->service = new Indexing($this->client);
    }

    protected function check()
    {
        if (!$this->client || !$this->service) {
            throw new \Exception('Google Service Account belum dikonfigurasi.');
        }
    }

    /**
     * Test koneksi Google
     */
    public function test()
    {
        $this->check();

        $token = $this->client->fetchAccessTokenWithAssertion();

        if (isset($token['error'])) {
            throw new \Exception(
                $token['error_description'] ?? $token['error']
            );
        }

        return true;
    }

    /**
     * Submit URL
     */
    public function submit(string $url, string $type = 'URL_UPDATED')
    {
        $this->check();

        $notification = new UrlNotification();

        $notification->setUrl($url);
        $notification->setType($type);

        return $this->service
            ->urlNotifications
            ->publish($notification);
    }

    /**
     * Remove URL
     */
    public function remove(string $url)
    {
        return $this->submit($url, 'URL_DELETED');
    }

    /**
     * Metadata
     */
    public function metadata(string $url)
    {
        $this->check();

        return $this->service
            ->urlNotifications
            ->getMetadata([
                'url' => $url
            ]);
    }
}