<?php

namespace Laralog\Laralog;

use Whitelist\Check;

use Closure;
use Asm89\Stack\CorsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\Response;

/**
* Based on barryvdh/laravel-cors laravel package. Had to extract it for support reasons.
* @see https://github.com/barryvdh/laravel-cors
*/
class HandleCors
{
    protected $cors;

    public function __construct()
    {
        $this->cors = new CorsService([
            'allowedHeaders'         => ['*'],
            'allowedMethods'         => ['*'],
            'allowedOrigins'         => ['*'],
            'exposedHeaders'         => ['Content-Length', 'X-Decompressed-Content-Length'],
            'maxAge'                 => 0,
            'supportsCredentials'    => false,
        ]);
    }

    /**
     * Handle an incoming request. Based on Asm89\Stack\Cors by asm89
     * @see https://github.com/asm89/stack-cors/blob/master/src/Asm89/Stack/Cors.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->cors->isCorsRequest($request)) {
            return $next($request);
        }
 
        if ($this->cors->isPreflightRequest($request)) {
            return $this->cors->handlePreflightRequest($request);
        }
 
        if (! $this->cors->isActualRequestAllowed($request)) {
            return new LaravelResponse('Not allowed in CORS policy.', 403);
        }
 
        $response = $next($request);
 
        return $this->addHeaders($request, $response);
    }
 
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    protected function addHeaders(Request $request, Response $response)
    {
        // Prevent double checking
        if (! $response->headers->has('Access-Control-Allow-Origin')) {
            $response = $this->cors->addActualRequestHeaders($response, $request);
        }
 
        return $response;
    }
}
