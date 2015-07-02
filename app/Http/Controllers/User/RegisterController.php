<?php namespace App\Http\Controllers\User;

use App\Models\Entities\User;
use App\Models\Entities\Breeds;
use App\Models\Repositories\UserRepositoryInterface;

class RegisterController extends \App\Http\Controllers\Controller
{

    protected $userRepository;
    protected $authUser;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->middleware('auth.user', array('only' => array('getAbout', 'putAbout')));
    }

    public function getAbout()
    {
        return \View::make('usersignup.stage1');
    }

    public function postAbout() // POST
    {

        $input = \Input::all();
        $id = $this->authUser->id;
        $validator = $this->userRepository->getUpdateValidator($input, $id);

        if ($validator->fails()) {
            return \Redirect::route('user.register.about')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        if (\Input::hasFile('image_path')) {
            $basePath = 'uploads/users/';
            if (!\File::exists($basePath)) {
                \File::makeDirectory($basePath);
            }
            $destinationPath = 'uploads/users/' . $id;
            if (!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }

            $extension = \Input::file('image_path')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;

            $height = \Image::make(\Input::file('image_path'))->height();
            $width = \Image::make(\Input::file('image_path'))->width();

            if ($width > $height) {
                \Image::make(\Input::file('image_path'))->crop($height, $height)->save($destinationPath . '/' . $fileName);
            } else {
                \Image::make(\Input::file('image_path'))->crop($width, $width)->save($destinationPath . '/' . $fileName);
            }

            $image_path = '/uploads/users/' . $id . '/' . $fileName;

            $input = array_merge($input, array('image_path' => $image_path));

        }

        if ($this->userRepository->update($this->authUser->id, $input) == false) {
            \App::abort(500);
        }

        return \Redirect::route('user.register.pet');
    }


}