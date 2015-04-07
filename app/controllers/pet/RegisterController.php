<?php namespace Pet;

use Entities\User;
use Repositories\UserRepositoryInterface;

class RegisterController extends \BaseController {
    
    protected $user;
    protected $authUser;

	public function __construct(UserRepositoryInterface $user)
	{
        $this->authUser = \Auth::user()->get();
        $this->user = $user;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('getAbout', 'putAbout')));
	}
    
    public function getAbout()
    {   
        return \View::make('petsignup.stage1');
    }
    
    public function postAbout() // POST
    {
       
        $input = \Input::all();
        $id =  \Auth::user()->get()->id;
        $validator = $this->user->getUpdateValidator($input, $id);
        
        if($validator->fails())
        {
            return \Redirect::to('pet/register/about')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }
        
        if (\Input::hasFile('image_path')){   
            $destinationPath = 'images/uploads/'.$id;
            if(!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }
            
            $extension = \Input::file('image_path')->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension;
            
            $height = \Image::make(\Input::file('image_path'))->height();
            $width = \Image::make(\Input::file('image_path'))->width();
            
            if($width > $height) {
                \Image::make(\Input::file('image_path'))->crop($height, $height)->save($destinationPath.'/'.$fileName);
            } 
            else {
                \Image::make(\Input::file('image_path'))->crop($width, $width)->save($destinationPath.'/'.$fileName);
            }
                            
            $image_path = '/images/uploads/'.$id.'/'.$fileName;
            
            $input = array_merge($input, array('image_path' => $image_path)); 
                    
        }     
            
        if($this->user->update($this->authUser->id, $input) == false)
        {
            \App::abort(500);
        }

        return \Redirect::to('pet/register/pet');
    }
    
    
}
