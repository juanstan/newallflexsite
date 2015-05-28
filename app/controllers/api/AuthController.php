<?php namespace Api;

use Entities\User\Token;
use Repositories\UserRepositoryInterface;

class AuthController extends \BaseController
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function postLogin()
    {
        $input = \Input::all();
        $validator = $this->userRepository->getLoginValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true, 'errors' => $validator->messages()]);
        }

        $user = $this->userRepository->getByEmailForLogin($input['email_address']);

        if ($user->tokens) {
            foreach ($user->tokens as $token) {
                $token->delete();
            }
        }

        $token = Token::generate($user);
        $user->tokens()->save($token);

        return \Response::json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);
    }

    public function postLogout()
    {
        if (\Auth::check()) {
            $user = \Auth::user();

            foreach ($user->tokens as $token) {
                $token->delete();
            }

            return \Response::json(['error' => false, 'message' => 'You are now logged out']);
        }

        return \Response::json(['error' => true, 'message' => 'Not logged in']);
    }
}
