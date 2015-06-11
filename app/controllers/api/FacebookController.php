<?php namespace Api;

use Entities\User\Token;
use Entities\User;
use Entities\Profile;
use Repositories\UserRepositoryInterface;

class FacebookController extends \BaseController
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function postCreate()
    {

        $input = \Input::all();
        $validator = $this->userRepository->getFacebookCreateValidator($input);

        if($validator->fails())
        {
            return \Response::json(['error' => true, 'errors' => $validator->messages()]);
        }

        $uid = \Input::get('id');
        $profile = Profile::where(['uid' => $uid, 'type' => 'facebook'])->first();
        if (empty($profile)) {

            $user = new User;
            $user->first_name = \Input::get('first_name');
            $user->last_name = \Input::get('last_name');
            $user->email = \Input::get('email');
            $user->units = 'F';
            $user->weight_units = 'KG';
            $user->image_path = 'https://graph.facebook.com/' . \Input::get('id') . '/picture?type=large';

            $user->save();

            $profile = new Profile();
            $profile->uid = $uid;
            $profile->type = 'facebook';
            $profile->username = \Input::get('id');
            $profile = $user->profiles()->save($profile);
            $profile->access_token = \Input::get('code');

            $profile->save();

            $user = $profile->user;

            $token = Token::generate($user);
            $user->tokens()->save($token);

            return \Response::json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);

        }
        else {
            return \Response::json(['error' => true, 'errors' => 'This Facebook user already exsists']);
        }

    }

    public function postLogin()
    {
        $input = \Input::all();
        $validator = $this->userRepository->getFacebookLoginValidator($input);

        if($validator->fails())
        {
            return \Response::json(['error' => true, 'errors' => $validator->messages()]);
        }

        $uid = \Input::get('id');
        $profile = Profile::where(['uid' => $uid, 'type' => 'facebook'])->first();
        if (empty($profile)) {
            return \Response::json(['error' => true, 'errors' => 'This Facebook user does not exsist']);
        }
        else {
            $user = $profile->user;

            if ($user->tokens) {
                foreach ($user->tokens as $token) {
                    $token->delete();
                }
            }

            $token = Token::generate($user);
            $user->tokens()->save($token);

            return \Response::json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);
        }
    }

}
