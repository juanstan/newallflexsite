<?php namespace Vet;

use Entities\Animal;
use Entities\User;
use Entities\Vet;
use Entities\SensorReading;
use Entities\SensorReadingSymptom;
use Entities\Symptom;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class RegisterController extends \BaseController {
    
    protected $user;
    protected $authUser;
    protected $repository;
    protected $rrepository;
    protected $srepository;

	public function __construct(VetRepositoryInterface $user, AnimalRepositoryInterface $repository, AnimalReadingRepositoryInterface $rrepository, AnimalReadingSymptomRepositoryInterface $srepository)
	{
        $this->authUser = \Auth::vet()->get();
        $this->user = $user;
        $this->rrepository = $rrepository;
        $this->repository = $repository;
        $this->srepository = $srepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getAbout', 'putAbout')));
	}
    
    public function getAbout()
    {   
        return \View::make('vetsignup.stage1');
    }
    
    public function postAbout() // POST
    {

        $input = \Input::all();
        $id =  \Auth::vet()->get()->id;
        $validator = $this->user->getUpdateValidator($input, $id);

        if($validator->fails())
        {
            return \Redirect::route('vet.register.about')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        if (\Input::hasFile('image_path')){
            $destinationPath = 'uploads/vets/'.$id;
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

            $image_path = '/uploads/vets/'.$id.'/'.$fileName;

            $input = array_merge($input, array('image_path' => $image_path));

        }

        if($this->user->update($this->authUser->id, $input) == false)
        {
            \App::abort(500);
        }

        return \Redirect::route('vet.register.address');
    }

    public function getAddress()
    {
        return \View::make('vetsignup.stage2');
    }

    public function postAddress() // POST
    {

        $input = \Input::all();
        $id =  \Auth::vet()->get()->id;
        $validator = $this->user->getUpdateValidator($input, $id);

        if($validator->fails())
        {
            return \Redirect::route('vet.register.about')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        $address = \Input::get('address_1') . ' ' . \Input::get('address_2') . ' ' . \Input::get('city') . ' ' . \Input::get('county') . ' ' . \Input::get('zip');

        $data_arr = geocode($address);

        if($data_arr) {
            $latitude = $data_arr[0];
            $longitude = $data_arr[1];
            $input = array_merge($input, array('latitude' => $latitude, 'longitude' => $longitude));
        }

        if($this->user->update($this->authUser->id, $input) == false)
        {
            \App::abort(500);
        }

        return \Redirect::route('vet.register.reading');
    }
    
    
}
