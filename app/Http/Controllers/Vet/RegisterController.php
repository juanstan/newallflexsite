<?php namespace App\Http\Controllers\Vet;

use Auth;
use Input;

use App\Models\Entities\Animal;
use App\Models\Entities\User;
use App\Models\Entities\Vet;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalReadingSymptomRepositoryInterface;
use App\Models\Repositories\VetRepositoryInterface;
use App\Http\Controllers\Controller;

class RegisterController extends Controller {
    
    protected $vetRepository;
    protected $authVet;
    protected $animalRepository;
    protected $animalReadingRepository;
    protected $animalReadingSymptomRepository;

	public function __construct(VetRepositoryInterface $vetRepository, AnimalRepositoryInterface $animalRepository, AnimalReadingRepositoryInterface $animalReadingRepository, AnimalReadingSymptomRepositoryInterface $animalReadingSymptomRepository)
	{
        $this->authVet = Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
        $this->middleware('vetAuth', array('only'=>array('getAbout', 'postAbout', 'getAddress', 'postAddress')));
	}
    
    public function getAbout()
    {
        $vet = $this->authVet;
        return View::make('vetsignup.stage1')
            ->with(array(
                'vet' => $vet
            ));
    }
    
    public function postAbout()
    {

        $input = Input::all();
        $id =  $this->authVet->id;
        $validator = $this->vetRepository->getUpdateValidator($input, $id);

        if($validator->fails())
        {
            return redirect()->route('vet.register.about')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        if (Input::hasFile('image_path')){
            $destinationPath = 'uploads/vets/'.$id;
            if(!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }

            $extension = Input::file('image_path')->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension;

            $height = \Image::make(Input::file('image_path'))->height();
            $width = \Image::make(Input::file('image_path'))->width();

            if($width > $height) {
                \Image::make(Input::file('image_path'))->crop($height, $height)->save($destinationPath.'/'.$fileName);
            }
            else {
                \Image::make(Input::file('image_path'))->crop($width, $width)->save($destinationPath.'/'.$fileName);
            }

            $image_path = '/uploads/vets/'.$id.'/'.$fileName;

            $input = array_merge($input, array('image_path' => $image_path));

        }

        if($this->vetRepository->update($this->authVet->id, $input) == false)
        {
            \App::abort(500);
        }

        return redirect()->route('vet.register.address');
    }

    public function getAddress()
    {
        return View::make('vetsignup.stage2');
    }

    public function postAddress() // POST
    {

        $input = Input::all();
        $id =  $this->authVet->id;
        $validator = $this->vetRepository->getUpdateValidator($input, $id);

        if($validator->fails())
        {
            return redirect()->route('vet.register.about')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        $address = Input::get('address_1') . ' ' . Input::get('address_2') . ' ' . Input::get('city') . ' ' . Input::get('county') . ' ' . Input::get('zip');

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

        return redirect()->route('vet.register.reading');
    }
    
    
}
