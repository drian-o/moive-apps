<?php

namespace App\Services;

use App\Services\Apify\ApifyService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SeoToolsService
{
    protected string $baseUrl = 'https://seo-tools-api-cyan.vercel.app';

    protected ApifyService $apify;

    public function __construct(ApifyService $apify)
    {
        $this->apify = $apify;
    }

    protected function get(string $endpoint, array $params = [])
    {
        $cacheKey = 'seo_tools_' . md5($endpoint . serialize($params));

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($endpoint, $params) {

            $response = Http::timeout(120)
                ->retry(2, 1000)
                ->acceptJson()
                ->get($this->baseUrl . $endpoint, $params);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'success' => false,
                'status' => $response->status(),
                'message' => $response->body(),
            ];
        });
    }

    /**
     * SEO Audit
     */
    public function seoAudit(string $url)
    {
        return $this->get('/seo-audit', [
            'url' => $url
        ]);
    }

    /**
     * Backlink Checker
     */
    public function backlinks(string $url)
    {
        return $this->get('/backlink-checker', [
            'url' => $url
        ]);
    }

    /**
     * Keyword Rank
     */
    public function rank(string $url, string $keyword)
    {
        return $this->get('/rank-checker', [
            'url' => $url,
            'keyword' => $keyword
        ]);
    }

    /**
     * Website Keywords
     */
    public function keywords(string $url)
    {
        return $this->get('/rank-checker/keywords', [
            'url' => $url
        ]);
    }

    /**
     * PageSpeed
     */
    public function pageSpeed(string $url)
    {
        return $this->get('/page-speed-analyzer', [
            'url' => $url
        ]);
    }

    /**
     * Sitemap
     */
    public function sitemap(string $url)
    {
        return $this->get('/sitemap-generator', [
            'url' => $url
        ]);
    }

    /**
     * Internal Linking
     */
    public function internalLinks(string $url)
    {
        return $this->get('/internal-linking', [
            'url' => $url
        ]);
    }

    /**
     * Content Optimization
     */
    public function contentOptimization(string $url)
    {
        return $this->get('/content-optimization', [
            'url' => $url
        ]);
    }

    /**
     * Social Media
     */
    public function socialMedia(string $url)
    {
        return $this->get('/social-media-integration', [
            'url' => $url
        ]);
    }

    /**
     * Competitor Analysis
     */
    public function competitor(array $urls, string $keyword)
    {
        return $this->get('/competitor-analysis', [
            'urls' => implode(',', $urls),
            'keyword' => $keyword
        ]);
    }

    /**
     * Full Analyze
     */
    public function analyze(string $url)
    {
        return [
            'seo_audit'      => $this->seoAudit($url),
            'backlinks'      => $this->backlinks($url),
            'keywords'       => $this->keywords($url),
            'pagespeed'      => $this->pageSpeed($url),
            'sitemap'        => $this->sitemap($url),
            'internal_links' => $this->internalLinks($url),
            'content'        => $this->contentOptimization($url),
            'social'         => $this->socialMedia($url),
        ];
    }

    /**
     * Generic Apify Runner
     */
protected function runApifyActor(string $actorId, array $input)
{
    set_time_limit(300);

    $run = $this->apify->runActor($actorId, $input);

    $runId = data_get($run, 'data.id');

    if (!$runId) {
        throw new \Exception('Failed to start actor.');
    }

    $status = null;

    $maxAttempts = 120; // maksimal 120 detik

    for ($i = 1; $i <= $maxAttempts; $i++) {

        $status = $this->apify->getRunStatus($runId);

        $state = data_get($status, 'status');

        logger()->info([
            'poll' => $i,
            'status' => $state,
        ]);

        if ($state === 'SUCCEEDED') {
            return $this->apify->getDataset(
                data_get($status, 'defaultDatasetId')
            );
        }

        if (in_array($state, [
            'FAILED',
            'ABORTED',
            'TIMED-OUT',
        ])) {
            throw new \Exception("Actor {$state}");
        }

        sleep(1);
    }

    throw new \Exception('Actor timeout after 120 seconds.');
}
    /**
     * Semrush Authority Checker
     */
 public function authorityChecker(array $domains)
{
    return $this->runApifyActor(
        config('apify.actors.semrush'),
        [
            'domains' => $domains,
        ]
    );
}

/**
 * Moz Authority Checker
 */
public function mozChecker(array $domains)
{
    $results = $this->runApifyActor(
        config('apify.actors.moz'),
        [
            'include_authority' => true,
            'include_history'   => true,
            'urls'              => array_map('trim', $domains),
        ]
    );

    return collect($results)->map(function ($item) {

        $authority = $item['authority_score'] ?? 0;

        return [

            'domain' => $item['domain'] ?? '',

            'authority' => $authority,

            'spam_score' => $item['spam_score'] ?? 0,

            'ref_domains' => $item['total_linking_root_domains'] ?? 0,

            'updated_at' => $item['last_updated'] ?? null,

            'captured_at' => $item['data_captured_at'] ?? null,

            'authority_label' => match (true) {
                $authority >= 80 => 'Excellent',
                $authority >= 60 => 'Very Strong',
                $authority >= 40 => 'Strong',
                $authority >= 20 => 'Average',
                default => 'Weak',
            },

            'authority_color' => match (true) {
                $authority >= 80 => 'green',
                $authority >= 60 => 'emerald',
                $authority >= 40 => 'blue',
                $authority >= 20 => 'yellow',
                default => 'red',
            },

            'top_pages' => collect($item['top_pages'] ?? [])
                ->map(fn ($page) => [
                    'url' => $page['page_url'] ?? '',
                    'authority' => $page['page_authority'] ?? 0,
                ])
                ->values(),

            'top_linking_domains' => collect($item['top_linking_domains'] ?? [])
                ->map(fn ($domain) => [
                    'domain' => $domain['domain'] ?? '',
                    'authority' => $domain['domain_authority'] ?? 0,
                ])
                ->values(),

            'history' => $item['backlinks_discovered_lost_history'] ?? [],

            'keywords' => $item['top_ranking_keywords'] ?? [],

            'competitors' => $item['top_competitors'] ?? [],

            'questions' => $item['top_questions'] ?? [],

        ];

    })->values();
}
}