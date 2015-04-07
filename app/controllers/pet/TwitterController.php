<?php  namespace Pet;

use Entities\User;
use Entities\Profile;
use Repositories\UserRepositoryInterface;
use Facebook\FacebookSession;
use \LaravelFacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

class TwitterController extends \BaseController {
    
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->authUser = \Auth::user()->get();
        $this->user = $user;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('getIndex', 'getNew', 'postNew')));
    }
    
    public function index()
    {
        // get data from input
        $token = \Input::get( 'oauth_token' );
        $verify = \Input::get( 'oauth_verifier' );

        // get twitter service
        $tw = \OAuth::consumer( 'Twitter' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $token ) && !empty( $verify ) ) {
            
                // This was a callback request from twitter, get the token
            $token = $tw->requestAccessToken( $token, $verify );

            // Send a request with it
            $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

            $uid = $result['id'];
            $profile = Profile::where(['uid' => $uid, 'type' => 'twitter'])->first();
            if (empty($profile)) {
                
                $user = new User;
                $user->units = 'F';
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

                if(\Auth::user()->get()->first_name != null) {
                    return \Redirect::to('/pet/dashboard')->with('message', 'Logged in with Twitter');
                } else {
                    return \Redirect::to('/pet/register/about')->with('message', 'Logged in with Twitter');
                }

            }
            else {
                
                $user = $profile->user;

                \Auth::user()->login($user);

                return \Redirect::to('/pet/dashboard')->with('message', 'Logged in with Twitter');    
                
            }

        }
        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return \Redirect::to( (string)$url );
        }     
    }
    
}
