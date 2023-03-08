<?php

namespace App\Http\Middleware;

use App\Supports\Traits\HasTransformer;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckDownloadCSVToken
{
    use HasTransformer;

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $expiration = config('sanctum.expiration');
        $personalToken = PersonalAccessToken::findToken($request->get('token'));
        if (!$personalToken || !$personalToken->can('server:download') || $personalToken->created_at->lte(now()->subMinutes($expiration))) {
            return $this->httpForbidden();
        }
        return $next($request);
    }
}
