<?php namespace User;

use Entities\User;
use Entities\Breeds;
use Repositories\UserRepositoryInterface;

class RegisterController extends \BaseController
{

    protected $user;
    protected $authUser;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->authUser = \Auth::user()->get();
        $this->user = $user;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getAbout', 'putAbout')));
    }

    public function getAbout()
    {
        return \View::make('usersignup.stage1');
    }

    public function postAbout() // POST
    {

        $input = \Input::all();
        $id = \Auth::user()->get()->id;
        $validator = $this->user->getUpdateValidator($input, $id);

        if ($validator->fails()) {
            return \Redirect::route('user.register.about')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        if (\Input::hasFile('image_path')) {
            $basePath = '/uploads/users/';
            if (!\File::exists($basePath)) {
                \File::makeDirectory($basePath);
            }
            $destinationPath = '/uploads/users/' . $id;
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

        if ($this->user->update($this->authUser->id, $input) == false) {
            \App::abort(500);
        }

        return \Redirect::route('user.register.pet');
    }


}
