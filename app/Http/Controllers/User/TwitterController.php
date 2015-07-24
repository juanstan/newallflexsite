<?php namespace App\Http\Controllers\User;

use App\Models\Entities\User;
use App\Models\Entities\Profile;
use App\Models\Repositories\UserRepositoryInterface;

class TwitterController extends \App\Http\Controllers\Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->userRepository = $userRepository;
    }

    public function getCreate()
    {
        $token = \Input::get('oauth_token');
        $verify = \Input::get('oauth_verifier');

        $tw = \OAuth::consumer('Twitter');

        if (!empty($token) && !empty($verify)) {

            $token = $tw->requestAccessToken($token, $verify);

            $result = json_decode($tw->request('account/verify_credentials.json'), true);

            $uid = $result['id'];
            $profile = Profile::where(['uid' => $uid, 'type' => 'twitter'])->first();
            if (empty($profile)) {

                $user = new User;
                $user->units = 'F';
                $user->weight_units = 'Kg';
                $user->image_path = str_replace('_normal.jpeg', '.jpeg', $result['profile_image_url']);

                $user->save();

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->type = 'twitter';
                $profile->username = $result['screen_name'];
                $profile = $user->profiles()->save($profile);
                $profile->access_token = $_GET['oauth_token'];

                $profile->save();

                $user = $profile->user;

                \Auth::user()->login($user);

                return \Redirect::route('user.register.about')->with('message', \Lang::get('general.You have registered with Twitter'));

            }
            else {
                return \Redirect::route('user.register')->with('error', \Lang::get('general.This Twitter user already exsists'));
            }

        }
        else {
            $reqToken = $tw->requestRequestToken();

            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            return \Redirect::to((string)$url);
        }
    }

    public function getLogin()
    {
        $token = \Input::get('oauth_token');
        $verify = \Input::get('oauth_verifier');

        $tw = \OAuth::consumer('Twitter');

        if (!empty($token) && !empty($verify)) {

            $token = $tw->requestAccessToken($token, $verify);

            $result = json_decode($tw->request('account/verify_credentials.json'), true);

            $uid = $result['id'];
            $profile = Profile::where(['uid' => $uid, 'type' => 'twitter'])->first();
            if (empty($profile)) {

                return \Redirect::route('user')->with('error', \Lang::get('general.This Twitter account is not yet registered'));

            }
            else {
                $user = $profile->user;

                \Auth::user()->login($user);
                return \Redirect::route('user.dashboard')->with('message', \Lang::get('general.Logged in with Twitter'));
            }

        }
        else {
            $reqToken = $tw->requestRequestToken();

            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            return \Redirect::to((string)$url);
        }
    }

}
