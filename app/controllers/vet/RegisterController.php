<?php namespace Vet;

use Entities\Animal;
use Entities\User;
use Entities\Vet;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\VetRepositoryInterface;

class RegisterController extends \BaseController {
    
    protected $vetRepository;
    protected $authVet;
    protected $animalRepository;
    protected $animalReadingRepository;
    protected $animalReadingSymptomRepository;

	public function __construct(VetRepositoryInterface $vetRepository, AnimalRepositoryInterface $animalRepository, AnimalReadingRepositoryInterface $animalReadingRepository, AnimalReadingSymptomRepositoryInterface $animalReadingSymptomRepository)
	{
        $this->authVet = \Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getAbout', 'postAbout', 'getAddress', 'postAddress')));
	}
    
    public function getAbout()
    {   
        return \View::make('vetsignup.stage1');
    }
    
    public function postAbout()
    {

        $input = \Input::all();
        $id =  $this->authVet->id;
        $validator = $this->vetRepository->getUpdateValidator($input, $id);

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

        if($this->vetRepository->update($this->authVet->id, $input) == false)
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
        $id =  $this->authVet->id;
        $validator = $this->vetRepository->getUpdateValidator($input, $id);

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

        if($this->vetRepository->update($this->authVet->id, $input) == false)
        {
            \App::abort(500);
        }

        return \Redirect::route('vet.register.reading');
    }
    
    
}
