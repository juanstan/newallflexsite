<?php namespace User;

use Entities\User;
use Entities\Profile;
use Repositories\UserRepositoryInterface;
use Facebook\FacebookSession;
use \LaravelFacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

class FacebookController extends \BaseController
{

    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->authUser = \Auth::user()->get();
        $this->user = $user;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getIndex', 'getNew', 'postNew')));
    }

    public function index()
    {

        $code = \Input::get('code');
        $fb = \OAuth::consumer('Facebook');

        if (!empty($code)) {

            $token = $fb->requestAccessToken($code);

            $result = json_decode($fb->request('/me'), true);

            $uid = $result['id'];
            $profile = Profile::where(['uid' => $uid, 'type' => 'facebook'])->first();
            if (empty($profile)) {

                $user = new User;
                $user->first_name = $result['first_name'];
                $user->last_name = $result['last_name'];
                $user->email_address = $result['email'];
                $user->units = 'F';
                $user->image_path = 'https://graph.facebook.com/' . $result['id'] . '/picture?type=large';

                $user->save();

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->type = 'facebook';
                $profile->username = $result['id'];
                $profile = $user->profiles()->save($profile);
                $profile->access_token = $_GET['code'];

            }

            $profile->save();

            $user = $profile->user;

            \Auth::user()->login($user);

            if ($this->authUser->first_name != null) {
                return \Redirect::route('user.dashboard')->with('message', 'Logged in with Facebook');
            } else {
                return \Redirect::route('user.register.about')->with('message', 'Logged in with Facebook');
            }


        } else {
            $url = $fb->getAuthorizationUri();

            return \Redirect::to((string)$url);
        }

    }

}
