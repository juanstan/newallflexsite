<?php namespace App\Http\Controllers\Api;

use Input;
use Auth;

use App\Models\Entities\Vet\Token;
use App\Models\Repositories\VetRepositoryInterface;
use App\Http\Controllers\Controller;

class VetAuthController extends Controller
{

    protected $vetRepository;

    public function __construct(VetRepositoryInterface $vetRepository)
    {
        $this->vetRepository = $vetRepository;
    }

    public function postLogin()
    {
        $input = Input::all();
        $validator = $this->vetRepository->getLoginValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->messages()]);
        }

        if (Auth::validate($input) == false) {
            return response()->json(['error' => true, 'errors' => ['password' => ['The password is incorrect']]]);
        }

        $vet = $this->vetRepository->getByEmailForLogin($input['email']);

        if ($vet->tokens) {
            foreach ($vet->tokens as $token) {
                $token->delete();
            }
        }

        $token = Token::generate($vet);
        $vet->tokens()->save($token);

        return response()->json(['error' => false, 'result' => ['token' => $token, 'vet' => $vet]]);
    }

    public function postLogout()
    {
        if (Auth::check()) {
            $vet = Auth::vet();

            foreach ($vet->tokens as $token) {
                $token->delete();
            }

            return response()->json(['error' => false, 'message' => 'You are now logged out']);
        }

        return response()->json(['error' => true, 'message' => 'Not logged in']);
    }
}
