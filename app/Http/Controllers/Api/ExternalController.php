<?php

namespace App\Http\Controllers\Api;

use Auth;
use Request;
use Validator;
use Input;
use Lang;
use Config;
use Password;
use ResetsPasswords;
use App\Http\Requests;
use Socialite;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Entities\User\Token;
/*
 * Repositories
 */
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\PhotoRepository;

class ExternalController extends Controller
{

    protected $user;
    protected $userRepository;
    protected $photoRepository;

    public function __construct(UserRepository $userRepository, PhotoRepository $photoRepository)
    {
        $this->user = Auth::user();
        $this->userRepository = $userRepository;
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function postLogin($provider)
    {
        $userData = json_decode(Request::getContent());
        $user = $this->userRepository->findByProviderOrCreateApi($userData, $provider);
        //$this->photoRepository->findProfilePictureOrCreate($userData->avatar, $user);
        $token = Token::generate($user);
        $user->tokens()->save($token);
        return Response::json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);
    }


}
