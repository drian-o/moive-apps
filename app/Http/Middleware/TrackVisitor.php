<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        Visitor::create([

            'ip'         => $request->ip(),

            'url'        => $request->path(),

            'user_agent' => $request->userAgent(),

            'referer'    => $request->headers->get('referer'),

            'country'    => null,

            'city'       => null,

        ]);

        return $next($request);
    }
}