<?php namespace App\Http\Controllers\User;

use View;
use Auth;
use Input;
use File;
use Image;

use App\Models\Entities\User;
use App\Models\Entities\Breeds;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\PhotoRepository;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{

    protected $userRepository;
    protected $photoRepository;
    protected $authUser;

    public function __construct(UserRepository $userRepository, PhotoRepository $photoRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->photoRepository = $photoRepository;
        $this->middleware('auth.user', array('only' => array('getAbout', 'putAbout')));
    }

    public function getAbout()
    {
        $user = $this->authUser;
        return View::make('usersignup.userRegister')
            ->with(array(
                'user' => $user,
            ));
    }

    public function postAbout()
    {

        $input = Input::all();
        $user = $this->authUser;
        $validator = $this->userRepository->getUpdateValidator($input, $user->id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        if (Input::hasFile('image_path')) {

            $imageValidator = $this->photoRepository->getCreateValidator($input);

            if ($imageValidator->fails()) {
                return redirect()->back()
                    ->withErrors($imageValidator)
                    ->withInput();
            }

            $photo = array(
                'title' => $user->id,
                'location' => $this->photoRepository->uploadImage($input['image_path'], $user)
            );

            $photoId = $this->photoRepository->createForUser($photo, $user);

            unset($input['image_path']);
            $input['photo_id'] = $photoId->id;

        }

        if ($this->userRepository->update($this->authUser->id, $input) == false) {
            \App::abort(500);
        }

        return redirect()->route('user.register.pet');
    }


}
