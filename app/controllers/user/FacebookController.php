<?php namespace User;

use Entities\User;
use Entities\Profile;
use Repositories\UserRepositoryInterface;

class FacebookController extends \BaseController
{

    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->authUser = \Auth::user()->get();
        $this->user = $user;
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function getCreate()
    {

        $code = \Input::get('code');
        $fb = \OAuth::consumer('Facebook');

        if (!empty($code)) {

            $token = $fb->requestAccessToken($code);

            var_dump($token);

            $result = json_decode($fb->request('/me'), true);

            dd($result);

            $uid = $result['id'];
            $profile = Profile::where(['uid' => $uid, 'type' => 'facebook'])->first();
            if (empty($profile)) {

                $user = new User;
                $user->first_name = $result['first_name'];
                $user->last_name = $result['last_name'];
                $user->email = $result['email'];
                $user->units = 'F';
                $user->weight_units = 'KG';
                $user->image_path = 'https://graph.facebook.com/' . $result['id'] . '/picture?type=large';

                $user->save();

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->type = 'facebook';
                $profile->username = $result['id'];
                $profile = $user->profiles()->save($profile);
                $profile->access_token = $_GET['code'];

                $profile->save();

                $user = $profile->user;

                \Auth::user()->login($user);

                return \Redirect::route('user.register.about')
                    ->with('message', \Lang::get('general.You have registered with Facebook'));

            }
            else {
                return \Redirect::route('user.register')
                    ->with('error', \Lang::get('general.This Facebook user already exsists'));
            }


        } else {
            $url = $fb->getAuthorizationUri();

            return \Redirect::to((string)$url);
        }

    }

    public function getLogin()
    {

        $code = \Input::get('code');
        $fb = \OAuth::consumer('Facebook');

        if (!empty($code)) {

            $token = $fb->requestAccessToken($code);

            $result = json_decode($fb->request('/me'), true);

            $uid = $result['id'];
            $profile = Profile::where(['uid' => $uid, 'type' => 'facebook'])->first();
            if (empty($profile)) {
                return \Redirect::route('user')
                    ->with('error', \Lang::get('general.This Facebook account is not yet registered'));
            }
            else {
                $user = $profile->user;

                \Auth::user()->login($user);
                return \Redirect::route('user.dashboard')
                    ->with('message', \Lang::get('general.Logged in with Facebook'));
            }

        }
        else {
            $url = $fb->getAuthorizationUri();

            return \Redirect::to((string)$url);
        }

    }

}
