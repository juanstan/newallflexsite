<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\Vet\Token;
use App\Models\Repositories\VetRepositoryInterface;

class VetAuthController extends \App\Http\Controllers\Controller
{

    protected $vetRepository;

    public function __construct(VetRepositoryInterface $vetRepository)
    {
        $this->vetRepository = $vetRepository;
    }

    public function postLogin()
    {
        $input = \Input::all();
        $validator = $this->vetRepository->getLoginValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true, 'errors' => $validator->messages()]);
        }

        if (\Auth::validate($input) == false) {
            return \Response::json(['error' => true, 'errors' => ['password' => ['The password is incorrect']]]);
        }

        $vet = $this->vetRepository->getByEmailForLogin($input['email']);

        if ($vet->tokens) {
            foreach ($vet->tokens as $token) {
                $token->delete();
            }
        }

        $token = Token::generate($vet);
        $vet->tokens()->save($token);

        return \Response::json(['error' => false, 'result' => ['token' => $token, 'vet' => $vet]]);
    }

    public function postLogout()
    {
        if (\Auth::check()) {
            $vet = \Auth::vet();

            foreach ($vet->tokens as $token) {
                $token->delete();
            }

            return \Response::json(['error' => false, 'message' => 'You are now logged out']);
        }

        return \Response::json(['error' => true, 'message' => 'Not logged in']);
    }
}
