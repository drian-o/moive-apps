<?php

namespace App\Services\Checker;

class CheckerManager
{
    protected KomdigiChecker $komdigi;

    public function __construct(KomdigiChecker $komdigi)
    {
        $this->komdigi = $komdigi;
    }

    public function scan(array $domains): array
    {
        $results = [];

        foreach ($domains as $domain) {

            $domain = trim($domain);

            if ($domain === '') {
                continue;
            }

            $results[] = $this->komdigi->check($domain);

        }

        return $results;
    }
}