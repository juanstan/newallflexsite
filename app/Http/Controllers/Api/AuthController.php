<?php namespace App\Http\Controllers\Api;

use Input;
use Auth;

use App\Models\Entities\User\Token;
use App\Models\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function postLogin()
    {
        $input = Input::all();
        $validator = $this->userRepository->getLoginValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->messages()]);
        }

        $user = $this->userRepository->getByEmailForLogin($input['email']);

        if ($user->tokens) {
            foreach ($user->tokens as $token) {
                $token->delete();
            }
        }

        $token = Token::generate($user);
        $user->tokens()->save($token);

        return response()->json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);
    }

    public function postLogout()
    {
        if (Auth::check()) {
            $user = Auth::user();

            foreach ($user->tokens as $token) {
                $token->delete();
            }

            return response()->json(['error' => false, 'message' => 'You are now logged out']);
        }

        return response()->json(['error' => true, 'message' => 'Not logged in']);
    }
}
