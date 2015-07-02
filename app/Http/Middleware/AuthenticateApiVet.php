<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateApiVet {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     */
    public function __construct()
    {
        $this->auth = Auth::vet();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $str_token = Request::header('X-Authorization');
        if($str_token == null)
        {
            return Response::json(['error' => true, 'errors' => ['Authorization' => [Lang::get('error.auth.header-missing')]]], 400);
        }
        else
        {
            $token = Entities\Vet\Token::with('vet')
                ->where('token', '=', $str_token)
                ->first();

            if($token == null || $token->expires_at->lt(\Carbon\Carbon::now()))
            {
                return Response::json(['error' => true, 'errors' => ['Authorization' => [Lang::get('error.auth.invalid-key')]]], 401);
            }

            Auth::setUser($token->vet);
            $token->expires_at = \Carbon\Carbon::parse(Entities\Vet\Token::TOKEN_EXPIRY);
            $token->save();
        }

        return $next($request);
    }

}