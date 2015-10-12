<?php namespace App\Http\Controllers\Vet;

use Auth;
use Input;
use View;

use App\Models\Entities\Pet;
use App\Models\Entities\User;
use App\Models\Entities\Vet;
use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PetReadingRepository;
use App\Models\Repositories\PetReadingSymptomRepository;
use App\Models\Repositories\VetRepository;
use App\Models\Repositories\PhotoRepository;
use App\Http\Controllers\Controller;

class RegisterController extends Controller {
    
    protected $vetRepository;
    protected $authVet;
    protected $petRepository;
    protected $petReadingRepository;
    protected $petReadingSymptomRepository;
    protected $photoRepository;

	public function __construct(
        VetRepository $vetRepository,
        PetRepository $petRepository,
        PetReadingRepository $petReadingRepository,
        PetReadingSymptomRepository $petReadingSymptomRepository,
        PhotoRepository $photoRepository
    )

	{
        $this->authVet = Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->petReadingSymptomRepository = $petReadingSymptomRepository;
        $this->photoRepository = $photoRepository;
        $this->middleware('auth.vet',
            array('only'=>
                array(
                    'getAbout',
                    'postAbout',
                    'getAddress',
                    'postAddress'
                )
            ));
	}
    
    public function getAbout()
    {
        $vet = $this->authVet;
        return View::make('vetsignup.vetRegister')
            ->with(array(
                'vet' => $vet
            ));
    }
    
    public function postAbout()
    {

        $input = Input::all();
        $vet =  $this->authVet;
        $validator = $this->vetRepository->getUpdateValidator($input, $vet->id);
        if($validator->fails())
        {
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
                'title' => $vet->id,
                'location' => $this->photoRepository->uploadVetImage($input['image_path'], $vet)
            );

            $photoId = $this->photoRepository->createForVet($photo, $vet);

            unset($input['image_path']);
            $input['photo_id'] = $photoId->id;

        }

        if($this->vetRepository->update($vet->id, $input) == false)
        {
            \App::abort(500);
        }

        return redirect()->route('vet.register.address');
    }

    public function getAddress()
    {
        $vet = $this->authVet;
        return View::make('vetsignup.addressRegister')
            ->with(array(
                'vet' => $vet
            ));
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
        $address = $input['address_1'] . ' ' . $input['address_2'] . ' ' . $input['city'] . ' ' . $input['county'] . ' ' . $input['zip'];
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
