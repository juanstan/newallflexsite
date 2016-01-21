<?php namespace App\Http\Controllers\User;

use View;
use Input;
use Lang;
use Auth;

use Carbon\Carbon;

use App\Models\Entities\Pet;
use App\Models\Entities\User;
use App\Models\Entities\Vet;

use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PetReadingRepository;
use App\Models\Repositories\PetReadingSymptomRepository;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\VetRepository;
use App\Models\Repositories\PhotoRepository;
use App\Models\Repositories\SymptomRepository;
use App\Models\Repositories\ConditionRepository;
use App\Models\Repositories\BreedRepository;
use App\Models\Repositories\HelpRepository;
use App\Models\Repositories\ReadingRepository;
use App\Models\Repositories\PetConditionRepository;
use App\Models\Repositories\SensorReadingSymptomRepository;
use App\Models\Repositories\PetRequestRepository;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    protected $userRepository;
    protected $petRepository;
    protected $petReadingRepository;
    protected $petReadingSymptomRepository;
    protected $photoRepository;
    protected $symptomRepository;
    protected $conditionRepository;
    protected $breedRepository;
    protected $helpRepository;
    protected $readingRepository;
    protected $petConditionRepository;
    protected $sensorReadingSymptomRepository;
    protected $petRequestRepository;

    public function __construct(
        UserRepository $userRepository,
        VetRepository $vetRepository,
        PetRepository $petRepository,
        PetReadingRepository $petReadingRepository,
        PetReadingSymptomRepository $petReadingSymptomRepository,
        PhotoRepository $photoRepository,
        SymptomRepository $symptomRepository,
        ConditionRepository $conditionRepository,
        BreedRepository $breedRepository,
        HelpRepository $helpRepository,
        ReadingRepository $readingRepository,
        PetConditionRepository $petConditionRepository,
        SensorReadingSymptomRepository $sensorReadingSymptomRepository,
        PetRequestRepository $petRequestRepository
    )

    {
        $this->authUser = Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->vetRepository = $vetRepository;
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->petReadingSymptomRepository = $petReadingSymptomRepository;
        $this->photoRepository = $photoRepository;
        $this->symptomRepository = $symptomRepository;
        $this->conditionRepository = $conditionRepository;
        $this->breedRepository = $breedRepository;
        $this->helpRepository = $helpRepository;
        $this->readingRepository = $readingRepository;
        $this->petConditionRepository = $petConditionRepository;
        $this->sensorReadingSymptomRepository = $sensorReadingSymptomRepository;
        $this->petRequestRepository = $petRequestRepository;

        $this->middleware('auth.user',
            array('only' =>
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
                    'postReadingUpload',
                    'postAssign',
                    'getVet'
                )
            )
        );

    }

    public function getIndex()
    {
        $user = $this->authUser;
        $this->petRepository->setUser($user);
        $symptoms = $this->symptomRepository->all();
        $conditions = $this->conditionRepository->all();
        $pets = $this->petRepository->petsSet();
        $microchips = $this->petRepository->microchipUnassigned();

        if($pets->isEmpty())
        {
            return redirect()->route('user.register.pet')
                ->with('error', \Lang::get('general.Your account has been created although no a pet has been assigned'));
        }

        $breed = $this->breedRepository->all()->lists('name', 'id');
        $data = array('pets','microchips','conditions','symptoms','breed','user');

        if ($this->authUser->confirmed != null) {
            array_push($data, ['not-verified' => '']);
        }

        return View::make('user.dashboard')->with(compact($data));

    }

    public function getHelp()
    {
        $help = $this->helpRepository->all();
        return View::make('user.help')->with(array('help' => $help));
    }

    public function getResult($id)
    {
        $help = $this->helpRepository->get($id);
        return View::make('user.result')
            ->with(
                array(
                    'help' => $help
                ));
    }

    public function postInvite()
    {
        \Mail::send('emails.vet-verify',
            array(
                'confirmation_code' => $this->authUser->confirmation_code
            ),
            function ($message) {
                $message->from('j.acevedo@sureflap.co.uk','SureFlap')->to(Input::get('email'))
                    ->subject($this->authUser->name, 'has invited you to use All Flex');
            }
        );
        return redirect()->route('user.dashboard')
            ->with('message', Lang::get('general.Verification email sent'));
    }


    public function postResetAverageTemperature($id)
    {
        $pet = $this->readingRepository->getByPetId($id);
        if ($this->readingRepository->update($pet->id, array('average' => 0))) {
            return redirect()->route('user.dashboard')
                ->with('success', Lang::get('general.Average temperature reset'));
        }
        return redirect()->route('user.dashboard')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }


    public function getSettings()
    {
        $user = $this->authUser;
        return View::make('user.settings')
            ->with(array(
                'user' => $user
            ));
    }


    public function postSettings()
    {
        $user = $this->authUser;
        $validator = $this->userRepository->getUpdateValidator(Input::all(), $user->id);
        if ($validator->fails())
        {
            return redirect()->route('user.dashboard.settings')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        if (Input::has('old_password'))
        {
            $password = Input::get('old_password');
            $passwordValidator = $this->userRepository->getPasswordCheckValidator($password, $user->password);
            if (!$passwordValidator)
            {
                return redirect()->route('user.dashboard.settings')
                    ->with('error', Lang::get('general.Password incorrect'));
            }
        }

        $input = Input::all();

        if(isset($input['password']) && $input['password'] == '')
        {
            unset($input['password']);
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

        if ($this->userRepository->update($user->id, $input) == false) {
            \App::abort(500);
        }
        return redirect()->route('user.dashboard')->with('success', Lang::get('general.Settings updated'));


    }


    public function postUpdatePet($id)
    {
        $user = $this->authUser;
        $input = Input::all();
        $this->petRepository->setUser($user);
        $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);
        if($breed)
        {
            $input['breed_id'] = $breed->id;
        }
        else
        {
            $input['breed_wildcard'] = $input['breed_id'];
        }
        if($user->weight_units == 1) {
            $input['weight'] = round($input['weight'] * 0.453592, 1);
        }
        $validator = $this->petRepository->getUpdateValidator($input);
        if ($validator->fails()) {
            return redirect()->route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        if ($this->petRepository->update($id, $input) == false) {
            \App::abort(500);
        }
        $pet = $this->petRepository->get($id);
        $userId = $user->id;
        if ($pet->vet_id != null) {
            $data = array(
                'vet_id' => $pet->vet_id,
                'user_id' => $userId,
                'pet_id' => $pet->id,
                'approved' => 1
            );
            $this->petRequestRepository->create($data);
        }
        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.Pet updated'));
    }


    public function postAddConditions($petId)
    {
        $this->petRepository->setUser($this->authUser);
        $conditions = Input::get('conditions');

        if (is_array($conditions)) {
            $this->petRepository->synchroniseConditions($petId, $conditions);
            return redirect()->route('user.dashboard')
                ->with('message', Lang::get('general.Conditions updated'));
        }
        return redirect()->route('user.dashboard');
    }


    public function postAddSymptoms($readingId)
    {
        $this->petRepository->setUser($this->authUser);
        $symptoms = Input::get('symptoms');

        if (is_array($symptoms)) {
            $this->readingRepository->synchroniseSymptoms($readingId, $symptoms);
            $message = 'general.Symptoms updated';

        } else {
            $message = 'general.No symptoms has been added';

        }

        return redirect()->route('user.dashboard')
            ->with('message', Lang::get($message));
    }


    public function getSymptomRemove($readingId, $symptomId)
    {
        if ($this->readingRepository->removeSymptom($readingId, $symptomId))
        {
            return redirect()->route('user.dashboard')
                ->with('success', Lang::get('general.Symptom removed'));
        }
        return redirect()->route('user.dashboard')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }


    public function postUpdatePetPhoto($id)
    {
        $input = Input::all();
        $user = $this->authUser;
        $this->petRepository->setUser($user);
        $imageValidator = $this->photoRepository->getCreateValidator($input);
        if($imageValidator->fails())
        {
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

        $this->petRepository->update($id, $input);

        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.Pet updated'));

    }


    public function postCreatePet()
    {
        $input = Input::all();
        $user = $this->authUser;
        $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);
        $this->petRepository->setUser($user);

        if($user->weight_units == 1) {
            $input['weight'] = $input['weight'] * 0.453592;
        }

        if($breed == NULL)
        {
            $input['breed_wildcard'] = $input['breed_id'];
        }
        else
        {
            $input['breed_id'] = $breed->id;
        }

        $validator = $this->petRepository->getCreateValidator($input);

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Input::hasFile('image_path')) {

            $imageValidator = $this->photoRepository->getCreateValidator($input);
            if($imageValidator->fails())
            {
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

        $pet = $this->petRepository->create($input);

        //We need to assign this new pet to all user vets
        $this->petRepository->attachDetachPetToMyVets($pet->id);

        if ($pet == null) {
            \App::abort(500);
        }

        return redirect()->route('user.dashboard');
    }


    public function getRemovePet($petId)
    {
        $this->petRepository->setUser($this->authUser);
        $this->petRepository->delete($petId);
        $this->petRequestRepository->removeByPetId($petId);
        $this->readingRepository->removeByPetId($petId);
        return redirect()->route('user.dashboard')
            ->with('message', Lang::get('general.Pet deleted'));
    }

    public function postReadingUpload()
    {
        $input = Input::all();
        $user = $this->authUser;

        $readingValidator = $this->petReadingRepository->getReadingUploadValidator($input);
        if ($readingValidator->fails()) {
            return redirect()->back()
                ->withErrors($readingValidator)
                ->withInput();
        }

        try {
            if($this->petReadingRepository->readingUpload($input, $user))
            {
                return response()->json([
                    'status'=>'success',
                    'message' => \Lang::get('general.Microchip has been added')
                ]);
            }

            return redirect()->route('register.reading')
                ->with('error', Lang::get('general.Uploaded file is not valid'));

        }catch (\Exception $e) {
            if ($e->getCode()===111) {
                return response()->json([
                    'status'=>'error',
                    'message' => \Lang::get('general.Microchip has been already registered')
                ]);
            }

            return response()->json([
                'status'=>'error',
                'message' => $e->getMessage()
            ]);

        }

    }

    public function getVet()
    {
        $this->petRepository->setUser($this->authUser);
        $pets = $this->petRepository->petsSet();
        $vets = $this->petRepository->getVetAssignedMyPets($pets);

        if($vets->isEmpty()) {
            return redirect()->route('user.dashboard')
                ->with('error', Lang::get('general.You must create a pet before you can perform this function.'));
        }

        return View::make('user.vet')->with(
            array(
                'vets' => $vets
            )
        );

    }


    public function getVetSearch()
    {
        $term = Input::get('term');
        $vets = $this->vetRepository->all();
        $result = [];
        foreach($vets as $vet) {
            if(strpos($vet->company_name, $term) !== false) {
                $result[] = ['id' => $vet->id, 'company_name' => $vet->company_name, 'city' => $vet->city, 'image_path' => $vet->image_path];
            }
        }
        return response()->json($result);
    }


    public function getVetSearchLocation()
    {
        $location = Input::get('term');
        $distance_set = '10';
        $data_arr = geocode($location);

        $coordA   = \Geotools::coordinate([$data_arr[0], $data_arr[1]]);
        $vets = $this->vetRepository->all();
        foreach($vets as $vet)
        {
            if($vet->latitude != null && $vet->longitude != null)
            {
                $coordB   = \Geotools::coordinate([$vet->latitude, $vet->longitude]);
                $distance = \Geotools::distance()->setFrom($coordA)->setTo($coordB);
                if($distance->in('km')->haversine() < $distance_set) {
                    $vet['distance'] = $distance->in('km')->haversine();
                    $result[] = $vet;
                }
                else {
                    continue;
                }
            }
            else {
                continue;
            }
        }

        if(empty($result)){
            return response()->json(['error' => true, 'message' => 'There are no vets in this area']);
        }

        return response()->json($result);

    }


    public function getAddVet($vetId)
    {
        $this->petRepository->setUser($this->authUser);
        $this->petRepository->attachDetachVet($vetId);

        return redirect()->route('user.dashboard.vet')
            ->with('success', Lang::get('general.Vet added'));
    }


    public function getRemoveVet($vetId)
    {
        $this->petRepository->setUser($this->authUser);
        $this->petRepository->attachDetachVet($vetId, 'detach');

        return redirect()->route('user.dashboard.vet')
            ->with('success', Lang::get('general.Vet removed'));

    }


    public function getActivatepet($pet_id,$vet_id)
    {
        if ($this->petRepository->UpdatingAttributePivot($vet_id, $pet_id, array('approved' => 1))){
            return redirect()->route('user.dashboard.vet')
                ->with('success', Lang::get('general.Pet activated'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }


    public function getDeactivatepet($pet_id,$vet_id)
    {
        if ($this->petRepository->UpdatingAttributePivot($vet_id, $pet_id, array('approved' => 0))){
            return redirect()->route('user.dashboard.vet')->with('success', Lang::get('general.Pet deactivated'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }


    public function postAssign($petId)
    {
        $pet = $this->petRepository->get(Input::get('pet-id'));
        $microchip = $this->petRepository->get($petId);

        if ($this->petRepository->assignMicrochipToPet($pet, $microchip)) {
            return redirect()->route('user.dashboard')
                ->with('success', Lang::get('general.Pet microchip number assigned'));
        }

        return redirect()->route('user.dashboard')
            ->with('error', Lang::get('general.Problem assigning microchip'));

    }

}
