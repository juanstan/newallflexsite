<?php

namespace App\Http\Controllers\User;

use Auth;
use Validator;
use Input;
use Lang;
use Password;
use ResetsPasswords;
use App\Http\Requests;
use Socialite;
use App\Http\Controllers\Controller;
use Config;
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

    public function getRedirect($provider)
    {
        Config::set('services.'.$provider.'.redirect', url('user/auth/'.$provider.'/callback'));
        return Socialite::driver($provider)->redirect();
    }

    public function getCallback($provider)
    {
        Config::set('services.'.$provider.'.redirect', url('user/auth/'.$provider.'/callback'));
        $userData = Socialite::driver($provider)->user();
        $user = $this->userRepository->findByProviderOrCreate($userData, $provider);
        $this->photoRepository->findProfilePictureOrCreate($userData->avatar, $user);
        Auth::user()->login($user);
        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.You have logged in successfully'));
    }

}
