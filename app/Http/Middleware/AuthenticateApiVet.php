<?php namespace App\Http\Middleware;

use App\Models\Entities\Vet\Token;
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
        $str_token = $request->header('X-Authorization') ?: $request->get('token');
        if($str_token == null)
        {
            return response()->json(['error' => true, 'errors' => ['Authorization' => [\Lang::get('error.auth.header-missing')]]], 400);
        }
        else
        {
            $token = Token::with('vet')
                ->where('token', '=', $str_token)
                ->first();

            if($token == null || $token->expires_at->lt(Carbon::now()))
            {
                return response()->json(['error' => true, 'errors' => ['Authorization' => [\Lang::get('error.auth.invalid-key')]]], 401);
            }

            \Auth::user()->login($token->vet);
            $token->expires_at = Carbon::parse(Token::TOKEN_EXPIRY);
            $token->save();
        }

        return $next($request);
    }

}