<?php

namespace App\Services\Checker;

use Spatie\Dns\Dns;

class NawalaChecker
{
public function check(string $domain): array
{
    $records = Dns::query()
        ->useNameserver('180.131.144.144')
        ->setTimeout(3)
        ->getRecords($domain);

    return [
        'domain' => $domain,
        'records' => $records,
    ];
}
}