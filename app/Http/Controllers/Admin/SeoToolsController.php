<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Services\SeoToolsService;
use Illuminate\Http\Request;

use App\Services\NawalaService;

class SeoToolsController extends Controller
{
    protected SeoToolsService $seo;
    protected NawalaService $nawala;

    public function __construct(
        SeoToolsService $seo,
        NawalaService $nawala
    ) {
        $this->seo = $seo;
        $this->nawala = $nawala;
    }

    /**
     * Halaman SEO Tools
     */
    public function index()
    {
        return view('admin.seo-tools.index');
    }

    /**
     * Halaman Authority Checker
     */
    public function authority()
    {
        return view('admin.seo-tools.authority-checker');
    }

    /**
     * Check Authority
     */
public function authorityCheck(Request $request)
{
    $request->validate([
        'domains' => 'required|string'
    ]);

    $domains = preg_split('/\r\n|\r|\n/', trim($request->domains));

    try {

        $moz = $this->seo->mozChecker($domains);
        $semrush = $this->seo->authorityChecker($domains);
        
        $results = [];

        foreach ($domains as $domain) {

            $mozItem = collect($moz)
                ->firstWhere('domain', trim($domain)) ?? [];

            $semrushItem = collect($semrush)
                ->firstWhere('domain', trim($domain)) ?? [];

            $results[] = [

                'domain' => $domain,

                // MOZ
                'authority'           => $mozItem['authority'] ?? 0,
                'spam_score'          => $mozItem['spam_score'] ?? 0,
                'top_pages'           => $mozItem['top_pages'] ?? [],
                'top_linking_domains' => $mozItem['top_linking_domains'] ?? [],
                'updated_at'          => $mozItem['updated_at'] ?? null,
                'captured_at'         => $mozItem['captured_at'] ?? null,

                // SEMRUSH
                'authority_score'     => $semrushItem['authority_score'] ?? 0,
                'backlinks'           => $semrushItem['backlinks'] ?? 0,
                'ref_domains'         => $semrushItem['referring_domains'] ?? 0,
                'organic_traffic'     => $semrushItem['organic_traffic'] ?? 0,
                'organic_keywords'    => $semrushItem['organic_keywords'] ?? 0,

                // TAMBAHAN
                'follow_backlinks'    => $semrushItem['follow_backlinks'] ?? 0,
                'nofollow_backlinks'  => $semrushItem['nofollow_backlinks'] ?? 0,

            ];
        }

        return response()->json($results);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ], 500);

    }
}

    /**
     * Full Analyze
     */
    public function analyze(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $result = $this->seo->analyze($request->url);

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * SEO Audit
     */
    public function audit(Request $request)
    {
        return response()->json(
            $this->seo->seoAudit($request->url)
        );
    }

    /**
     * Backlinks
     */
    public function backlinks(Request $request)
    {
        return response()->json(
            $this->seo->backlinks($request->url)
        );
    }

    /**
     * Keywords
     */
    public function keywords(Request $request)
    {
        return response()->json(
            $this->seo->keywords($request->url)
        );
    }

    /**
     * Keyword Rank
     */
    public function rank(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'keyword' => 'required'
        ]);

        return response()->json(
            $this->seo->rank(
                $request->url,
                $request->keyword
            )
        );
    }

    /**
     * PageSpeed
     */
    public function pageSpeed(Request $request)
    {
        return response()->json(
            $this->seo->pageSpeed($request->url)
        );
    }

    /**
     * Sitemap
     */
    public function sitemap(Request $request)
    {
        return response()->json(
            $this->seo->sitemap($request->url)
        );
    }

    /**
     * Internal Linking
     */
    public function internal(Request $request)
    {
        return response()->json(
            $this->seo->internalLinks($request->url)
        );
    }

    /**
     * Content Optimization
     */
    public function content(Request $request)
    {
        return response()->json(
            $this->seo->contentOptimization($request->url)
        );
    }

   public function scan(Request $request, NawalaService $nawala)
{
    $request->validate([
        'domains' => 'required|string',
    ]);

    $domains = collect(
        preg_split('/\r\n|\r|\n/', trim($request->domains))
    )
        ->map(fn($domain) => trim($domain))
        ->filter()
        ->unique()
        ->values()
        ->toArray();

    try {

        $response = $nawala->checkDomains($domains);

        $rows = $response['data'] ?? [];

        // Jika API mengembalikan object (1 domain), ubah menjadi array
        if (isset($rows['domain'])) {
            $rows = [$rows];
        }

        $allowed = 0;
        $blocked = 0;

        foreach ($rows as $row) {

            $isBlocked =
                ($row['nawala']['blocked'] ?? false) ||
                ($row['network']['blocked'] ?? false);

            if ($isBlocked) {
                $blocked++;
            } else {
                $allowed++;
            }

        }

        return response()->json([
            'success'   => true,
            'total'     => count($rows),
            'allowed'   => $allowed,
            'blocked'   => $blocked,
            'data'      => $rows,
            'rateLimit' => $response['rate_limit'] ?? null,
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ], 500);

    }
}
/*
|--------------------------------------------------------------------------
| SHORTLINK
|--------------------------------------------------------------------------
*/

public function shortlinks()
{
    return view('admin.seo-tools.shortlinks');
}

public function shortlinksList(NawalaService $nawala)
{
    return response()->json(
        $nawala->getShortlinks()
    );
}

/**
 * Pilihan shortlink untuk dropdown Links.
 */
public function shortlinksOptions()
{
    $response = $this->nawala->getShortlinks();

    $items = collect($response['data'] ?? [])
        ->filter(function ($item) {
            return filter_var(
                $item['is_active'] ?? true,
                FILTER_VALIDATE_BOOLEAN
            );
        })
        ->map(function ($item) {
            return [
                'id'   => $item['id'] ?? null,
                'name' => $item['name'] ?? 'Tanpa Nama',
                'slug' => $item['slug'] ?? '',
            ];
        })
        ->filter(fn ($item) => !empty($item['id']))
        ->values();

    return response()->json([
        'success' => true,
        'data' => $items,
    ]);
}

public function createShortlink(Request $request)
{
    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:150',
        ],
        'slug' => [
            'required',
            'string',
            'max:150',
            'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
        ],
        'description' => [
            'nullable',
            'string',
            'max:500',
        ],
        'is_active' => [
            'required',
            'boolean',
        ],
    ]);

    try {
        $result = $this->nawala->createShortlink([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'],
        ]);

        logger()->info('Nawala createShortlink response', [
            'request' => $validated,
            'response' => $result,
        ]);

        if (($result['success'] ?? false) !== true) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
                    ?? $result['error']
                    ?? 'Nawala API menolak pembuatan shortlink.',
                'api_response' => $result,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Shortlink berhasil dibuat.',
            'data' => $result['data'] ?? $result,
        ], 201);

    } catch (\Throwable $e) {
        report($e);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function updateShortlink(Request $request, string $id)
{
    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:150',
        ],
        'slug' => [
            'required',
            'string',
            'max:150',
            'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
        ],
        'description' => [
            'nullable',
            'string',
            'max:500',
        ],
        'is_active' => [
            'required',
            'boolean',
        ],
    ]);

    try {
        $result = $this->nawala->updateShortlink($id, [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'],
        ]);

        return response()->json($result);
    } catch (\Throwable $e) {
        report($e);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function deleteShortlink(string $id)
{
    try {
        return response()->json(
            $this->nawala->deleteShortlink($id)
        );
    } catch (\Throwable $e) {
        report($e);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

/*
|--------------------------------------------------------------------------
| LINKS
|--------------------------------------------------------------------------
*/

public function links()
{
    return view('admin.seo-tools.links');
}

public function createLink(Request $request)
{
    return response()->json(
        $this->nawala->createLink([
            'url'          => $request->url,
            'domain'       => $request->domain,
            'status'       => $request->status,
            'priority'     => $request->priority,
            'shortlink_id' => $request->shortlink_id,
        ])
    );
}

public function linksList(Request $request)
{
    $shortlinks = $this->nawala->getShortlinks();

    $rows = [];

    foreach ($shortlinks['data'] ?? [] as $shortlink) {

        foreach ($shortlink['links'] ?? [] as $link) {

            $rows[] = [
                'id' => $link['id'],
                'url' => $link['url'],
                'domain' => $link['domain'],
                'priority' => $link['priority'],
                'status' => $link['status'],
                'shortlink' => [
                    'id' => $shortlink['id'],
                    'name' => $shortlink['name'],
                    'slug' => $shortlink['slug'],
                ],
            ];
        }
    }

    if ($request->search) {

        $rows = array_filter($rows, function ($item) use ($request) {
            return str_contains(
                strtolower($item['url']),
                strtolower($request->search)
            );
        });

    }

    if ($request->status) {

        $rows = array_filter($rows, function ($item) use ($request) {
            return $item['status'] === $request->status;
        });

    }

    return response()->json([
        'success' => true,
        'data' => array_values($rows),
    ]);
}

public function deleteLink(string $id)
{
    return response()->json(
        $this->nawala->deleteLink($id)
    );
}


/*
|--------------------------------------------------------------------------
| ANALYTICS
|--------------------------------------------------------------------------
*/

public function analytics()
{
    return view('admin.seo-tools.analytics');
}

public function analyticsData(NawalaService $nawala)
{
    $analytics = $nawala->analytics();

    return response()->json([
        'success' => $analytics['success'] ?? false,
        'summary' => $analytics['summary'] ?? [],
        'data'    => $analytics['data'] ?? [],
        'total'   => $analytics['total'] ?? 0,
    ]);
}

public function analyticsDetail(NawalaService $nawala, string $id)
{
    return response()->json(
        $nawala->analytics($id)
    );
}
public function linkDetail(string $id)
{
    return response()->json(
        $this->nawala->link($id)
    );
}

public function updateLink(Request $request, string $id)
{
    return response()->json(
        $this->nawala->updateLink($id, [
            'url'          => $request->url,
            'domain'       => $request->domain,
            'status'       => $request->status,
            'priority'     => $request->priority,
            'shortlink_id' => $request->shortlink_id,
        ])
    );
}
}