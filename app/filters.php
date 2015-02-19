<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('auth.api', function()
{
    $str_token = Request::header('X-Authorization');
    if($str_token == null)
    {
        return Response::json(['error' => true, 'errors' => ['Authorization' => [Lang::get('error.auth.header-missing')]]], 400);
    }
    else
    {
        $token = Entities\User\Token::with('user')
            ->where('token', '=', $str_token)
            ->first();

        if($token == null || $token->expires_at->lt(\Carbon\Carbon::now()))
        {
            return Response::json(['error' => true, 'errors' => ['Authorization' => [Lang::get('error.auth.invalid-key')]]], 401);
        }

        Auth::setUser($token->user);
        $token->expires_at = \Carbon\Carbon::parse(Entities\User\Token::TOKEN_EXPIRY);
        $token->save();
    }
});

Route::filter('vet.auth.api', function()
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
});

Route::filter('api.before', function()
{
    Config::set('session.driver', 'array');

    App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $e, $code)
    {
        return Response::json(['error' => true, 'message' => Lang::get('error.model.404')], 404);
    });

    App::error(function(Symfony\Component\HttpKernel\Exception\HttpException $e, $code)
    {
        return Response::json(['error' => true, 'message' => Lang::get('error.http.'.$code)], $code);
    });

    // catch any uncaught exceptions
    App::error(function(Exception $e)
    {
        if(App::environment('production'))
        {
            return Response::json(['error' => true, 'message' => Lang::get('error.http.500')], 500);
        }
    });
});
