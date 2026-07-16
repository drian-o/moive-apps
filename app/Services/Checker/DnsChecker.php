<?php

namespace App\Services\Checker;

use Spatie\Dns\Dns;

class DnsChecker
{
    public function check(string $domain): array
    {
        try {

            $records = Dns::query()->getRecords($domain);

            return [
                'success' => true,
                'records' => $records,
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];

        }
    }
}