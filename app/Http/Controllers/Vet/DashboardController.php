<?php namespace App\Http\Controllers\Vet;

use Auth;
use View;
use Input;
use Lang;

use App\Models\Entities\Pet;
use App\Models\Entities\Vet;
use App\Models\Repositories\PetRepositoryInterface;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetReadingSymptomRepositoryInterface;
use App\Models\Repositories\VetRepositoryInterface;
use App\Models\Repositories\PetRequestRepository;
use App\Models\Repositories\SymptomRepository;
use App\Models\Repositories\HelpRepository;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    protected $vetRepository;
    protected $petRepository;
    protected $petReadingRepository;
    protected $petReadingSymptomRepository;
    protected $petRequestRepository;
    protected $symptomRepository;
    protected $helpRepository;

    public function __construct(
        VetRepositoryInterface $vetRepository, 
        PetRepositoryInterface $petRepository,
        PetReadingRepositoryInterface $petReadingRepository,
        PetReadingSymptomRepositoryInterface $petReadingSymptomRepository,
        PetRequestRepository $petRequestRepository,
        SymptomRepository $symptomRepository,
        HelpRepository $helpRepository
    )
    {
        $this->authVet = Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->petReadingSymptomRepository = $petReadingSymptomRepository;
        $this->petRequestRepository = $petRequestRepository;
        $this->symptomRepository = $symptomRepository;
        $this->helpRepository = $helpRepository;
        $this->middleware('auth.vet',
            array('only'=>
                array(
                    'getIndex',
                    'postResetAverageTemperature',
                    'getSettings',
                    'postSettings',
                    'postUpdatePet',
                    'postAddSymptoms',
                    'postUpdatePetPhoto',
                    'postCreatePet',
                    'getRemovePet',
                    'postReadingUpload'
                )
            )
        );

    }

    public function getIndex() {
        $vet = $this->authVet;
        $this->petRepository->setUser($vet);
        $symptoms = $this->symptomRepository->all();
        $requests = $this->petRequestRepository->getAllByVetId($vet->id);
        $pets = $this->petRepository->all();
        if ($vet->confirmed != null) {
            return View::make('vet.dashboard')
                ->with(array(
                    'pets' => $pets,
                    'symptoms' => $symptoms,
                    'requests' => $requests,
                    'vet' => $vet
                ));
        }
        else {
            return View::make('vet.dashboard')
                ->with(array(
                    'not-verified' => '',
                    'pets' => $pets,
                    'symptoms' => $symptoms,
                    'requests' => $requests,
                    'vet' => $vet
                ));
        }
    }

    public function getHelp() {

        $help = $this->helpRepository->all();
        return View::make('vet.help')
            ->with(array(
                'help' => $help
            ));

    }

    public function getResult($id) {

        $help = $this->helpRepository->get($id);
        return View::make('vet.result')
            ->with(array(
                'help' => $help
            ));

    }

    public function postInvite() {

        \Mail::send('emails.vet-verify', array('confirmation_code' => $this->authVet->confirmation_code), function($message) {
            $message->to(Input::get('email'))
                ->subject($this->authVet->name, 'has invited you to use All Flex');
        });
        return redirect()->route('vet.dashboard')
            ->with('message', Lang::get('general.Verification email sent'));
    }

    public function getPet($petId) {
        $this->petRepository->setUser($this->authVet);
        $vetid = $this->authVet->id;
        $symptoms = $this->symptomRepository->all();
        $pet = $this->petRepository->get($petId);
        if($this->petRequestRepository->getApprovedByVetAndPetId($vetid, $petId))
        {
            return View::make('vet.information')
                ->with(array(
                    'pet' => $pet,
                    'symptoms' => $symptoms
                ));
        }
        else
        {
            return View::make('vet.dashboard')
                ->with(array(
                    'not-verified' => '',
                    'pet' => $pet,
                    'symptoms' => $symptoms
                ));
        }


    }

    public function postResetAverageTemperature($id)
    {
        $pet = $this->sensorReadingRepository->getByPetId($id);
        if ($this->sensorReadingRepository->update($pet->id, array('average' => 0)))
        {
            return redirect()->route('user.dashboard')
                ->with('success', Lang::get('general.Average temperature reset'));
        }

        return redirect()->route('user.dashboard')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function getSettings()
    {
        return View::make('vet.settings');
    }

    public function postSettings()
    {
        $vet =  $this->authVet;
        $validator = $this->vetRepository->getUpdateValidator(Input::all(), $vet->id);
        if($validator->fails())
        {
            return redirect()->route('vet.dashboard.settings')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        if (Input::has('old_password'))
        {
            $password = Input::get('old_password');
            if (!\Hash::check($password, $this->authVet->password))
            {
                return redirect()->route('vet.dashboard.settings')
                    ->with('error', Lang::get('general.Password incorrect'));
            }
        }

        $input = Input::only(array(
            'company_name',
            'contact_name',
            'email',
            'telephone',
            'fax',
            'address_1',
            'address_2',
            'city',
            'county',
            'zip',
            'units',
            'latitude',
            'longitude',
            'image_path',
            'password',
        ));

        if($input['password'] == '')
        {
            unset($input['password']);
        }

        if ($input['image_path'] != ''){

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
        else {

            $input['image_path'] = $this->authVet->image_path;

        }

        $address = Input::get('address_1') . ' ' . Input::get('address_2') . ' ' . Input::get('city') . ' ' . Input::get('county') . ' ' . Input::get('zip');

        $data_arr = geocode($address);

        if($data_arr) {
            $latitude = $data_arr[0];
            $longitude = $data_arr[1];
            $input['latitude'] = $latitude;
            $input['longitude'] = $longitude;
        }

        if($this->vetRepository->update($this->authVet->id, $input) == false)
        {
            \App::abort(500);
        }

        return redirect()->route('vet.dashboard')
            ->with('success', Lang::get('general.Settings updated'));
    }

    public function postReadingUpload()
    {
        $input = Input::all();
        $vet = $this->authVet;
        $readingValidator = $this->petReadingRepository->getReadingUploadValidator($input);
        if ($readingValidator->fails()) {
            return redirect()->back()
                ->withErrors($readingValidator)
                ->withInput();
        }

        if($this->petReadingRepository->readingUploadVet($input, $vet))
        {
            return redirect()->route('vet.dashboard');
        }

        return redirect()->route('vet.dashboard')
            ->with('error', Lang::get('general.Uploaded file is not valid'));
    }


}
