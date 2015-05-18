<?php namespace Api;

use Entities\Vet\Token;
use Repositories\VetRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VetAuthController extends \BaseController
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

        $vet = $this->vetRepository->getByEmailForLogin($input['email_address']);

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
