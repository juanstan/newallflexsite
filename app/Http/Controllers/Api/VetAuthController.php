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

        if (Auth::vet()->attempt($input)) {
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

        return response()->json(['error' => true, 'result' => 'Vet details are incorrect']);
    }

    public function postLogout()
    {
        if (Auth::vet()->check()) {
            $vet = Auth::vet()->get();
            foreach ($vet->tokens() as $token) {
                $token->delete();
            }

            return response()->json(['error' => false, 'message' => 'You are now logged out']);
        }

        return response()->json(['error' => true, 'message' => 'Not logged in']);
    }
}
