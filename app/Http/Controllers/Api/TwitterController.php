<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\User\Token;
use App\Models\Entities\User;
use App\Models\Entities\Profile;
use App\Models\Repositories\UserRepositoryInterface;

class TwitterController extends \App\Http\Controllers\Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function postCreate()
    {
        $input = \Input::all();
        $validator = $this->userRepository->getTwitterCreateValidator($input);

        if($validator->fails())
        {
            return \Response::json(['error' => true, 'errors' => $validator->messages()]);
        }

        $uid = \Input::get('id');
        $profile = Profile::where(['uid' => $uid, 'type' => 'twitter'])->first();
        if (empty($profile)) {

            $user = new User;
            $user->units = 'F';
            $user->weight_units = 'KG';
            $user->image_path = str_replace('_normal.jpeg', '.jpeg', \Input::get('profile_image_url'));

            $user->save();

            $profile = new Profile();
            $profile->uid = $uid;
            $profile->type = 'twitter';
            $profile->username = \Input::get('screen_name');
            $profile = $user->profiles()->save($profile);
            $profile->access_token = \Input::get('oauth_token');

            $profile->save();

            $user = $profile->user;

            $token = Token::generate($user);
            $user->tokens()->save($token);

            return \Response::json(['error' => false, 'result' => ['token' => $token, 'user' => $user]]);

        }
        else {
            return \Response::json(['error' => true, 'errors' => 'This Twitter user already exsists']);
        }

    }

    public function postLogin()
    {

        $input = \Input::all();
        $validator = $this->userRepository->getTwitterLoginValidator($input);

        if($validator->fails())
        {
            return \Response::json(['error' => true, 'errors' => $validator->messages()]);
        }

        $uid = \Input::get('id');
        $profile = Profile::where(['uid' => $uid, 'type' => 'twitter'])->first();
        if (empty($profile)) {

            return \Response::json(['error' => true, 'errors' => 'This Twitter user does not exsist']);

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
