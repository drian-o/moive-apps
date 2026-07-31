<?php

return [

    'token' => env('APIFY_TOKEN'),

    'base_url' => env('APIFY_BASE_URL', 'https://api.apify.com/v2'),

    'actors' => [

        'semrush' => env(
            'APIFY_SEMRUSH_ACTOR',
            'pro100chok/semrush-scraper'
        ),

        'moz' => env(
            'APIFY_MOZ_ACTOR',
            'radeance/moz-scraper'
        ),

    ],

];