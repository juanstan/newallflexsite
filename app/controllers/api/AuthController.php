<?php namespace Api;

use Entities\User\Token;
use Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends \BaseController {

	protected $user;

	public function __construct(UserRepositoryInterface $user)
	{
		$this->user = $user;
	}

	public function postLogin()
	{
		$input = \Input::all();
		$validator = $this->user->getLoginValidator($input);

		if($validator->fails())
		{
			return \Response::json(['error' => true, 'errors' => $validator->messages()]);
		}

//		if(\Auth::validate($input) == false)
//		{
//			return \Response::json(['error' => true, 'errors' => ['password' => ['The password is incorrect']]]);
//		}

		$user = $this->user->getByEmailForLogin($input['email_address']);

		if($user->tokens)
		{
			foreach($user->tokens as $token)
			{
				$token->delete();
			}
		}

		$token = Token::generate($user);
		$user->tokens()->save($token);

		return \Response::json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);
	}

	public function postLogout()
	{
		if(\Auth::check())
		{
			$user = \Auth::user();

			foreach($user->tokens as $token)
			{
				$token->delete();
			}

			return \Response::json(['error' => false, 'message' => 'You are now logged out']);
		}

		return \Response::json(['error' => true, 'message' => 'Not logged in']);
	}
}
