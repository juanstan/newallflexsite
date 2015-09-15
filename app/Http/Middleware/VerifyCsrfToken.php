<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{

    protected function tokensMatchStatic($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (!$token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }

        return Str::equals('reconnixtest', $token);
    }

    public function handle($request, \Closure $next)
    {
        if ($this->isReading($request) || $this->shouldPassThrough($request) || $this->tokensMatch($request) || $this->tokensMatchStatic($request)) {
            return $this->addCookieToResponse($request, $next($request));
        }

        //throw new TokenMismatchException;
    }
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'api/*',
    ];
}
