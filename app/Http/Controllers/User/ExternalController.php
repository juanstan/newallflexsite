<?php

namespace App\Http\Controllers\User;

use Auth;
use Validator;
use Input;
use Lang;
use Password;
use Session;
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
use App\Models\Repositories\PetRepository;

class ExternalController extends Controller
{

    protected $user;
    protected $userRepository;
    protected $photoRepository;
    protected $petRepository;

    public function __construct(UserRepository $userRepository, PhotoRepository $photoRepository, PetRepository $petRepository)
    {
        $this->user = Auth::user();
        $this->userRepository = $userRepository;
        $this->photoRepository = $photoRepository;
        $this->petRepository = $petRepository;
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
        $user = Auth::user()->get();
        $this->petRepository->setUser($user);
        $pets = $this->petRepository->all();
        if($pets->isEmpty())
        {
            return redirect()->route('user.register.pet')
                ->with('success', Lang::get('general.Your accont has been created successfully'));
        }
        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.You have logged in successfully'));
    }

}
