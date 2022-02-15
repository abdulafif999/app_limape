<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Cache::has($this->cacheKey($request))){
            return response(Cache::get($this->cacheKey($request)));
        }

        return $next($request);
    }
    public function terminate($request,  $response)
    {
        if(Cache::has($this->cacheKey($request))){
            return;
        }
        $contents = $response->getContent();

        Cache::put($this->cacheKey($request), $contents, 60*60*24);
    }
    public function cacheKey($request)
    {
        return md5($request->fullUrl().'-'.auth()->user()->name);
    }
}
