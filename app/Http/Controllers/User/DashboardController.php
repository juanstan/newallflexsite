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
use App\Models\Repositories\SensorReadingRepository;
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
    protected $sensorReadingRepository;
    protected $petConditionRepository;
    protected $sensorReadingSymptomRepository;
    protected $petRequestRepository;

    public function __construct(
        UserRepository $userRepository,
        VetRepository $vetRepository,
        PetRepository $petRepository,
        PetReadingRepository $petReadingRepository,
        PetReadingSymptomRepository
        $petReadingSymptomRepository,
        PhotoRepository $photoRepository,
        SymptomRepository $symptomRepository,
        ConditionRepository $conditionRepository,
        BreedRepository $breedRepository,
        HelpRepository $helpRepository,
        SensorReadingRepository $sensorReadingRepository,
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
        $this->sensorReadingRepository = $sensorReadingRepository;
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
                    'postAssign'
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

        if ($this->authUser->confirmed != null) {
            return View::make('user.dashboard')
                ->with(
                    array(
                        'pets' => $pets,
                        'microchips' => $microchips,
                        'conditions' => $conditions,
                        'symptoms' => $symptoms,
                        'breed' => $breed,
                        'user' => $user
                    )
                );
        } else {
            return View::make('user.dashboard')
                ->with(
                    array(
                        'not-verified' => '',
                        'pets' => $pets,
                        'microchips' => $microchips,
                        'conditions' => $conditions,
                        'symptoms' => $symptoms,
                        'breed' => $breed,
                        'user' => $user
                    ));
        }

    }

    public function getHelp()
    {
        $help = $this->helpRepository->all();
        return View::make('user.help')
            ->with(
                array(
                    'help' => $help
                ));
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
        $pet = $this->sensorReadingRepository->getByPetId($id);
        if ($this->sensorReadingRepository->update($pet->id, array('average' => 0))) {
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
            $this->petConditionRepository->removeAndUpdateConditions($petId, $conditions);
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
            $this->sensorReadingSymptomRepository->removeAndUpdateSymptoms($readingId, $symptoms);
            return redirect()->route('user.dashboard')
                ->with('message', Lang::get('general.Symptoms updated'));
        }
        return redirect()->route('user.dashboard');
    }

    public function getSymptomRemove($readingId, $symptomId)
    {
        if($this->sensorReadingSymptomRepository->removeSymptomById($readingId, $symptomId))
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
        $this->assignPetToMyVets($pet->id);

        if ($pet == null) {
            \App::abort(500);
        }

        return redirect()->route('user.dashboard');
    }


    /*
     * Function to assign a pet to all Vet (for the loggedin user)
     *
     * @paran int $iPetID   The pet ID
     *
     * @return  void
     */
    private function assignPetToMyVets($iPetID)
    {
        $user = $this->authUser;
        $vets=[];

        foreach ($this->petRequestRepository->getAllByUserId($user->id) as $petRequest){
            if (in_array($petRequest->vet_id,  $vets)){
                continue;

            } else {
                $this->petRequestRepository->create(
                    array(
                        'vet_id'        =>  $petRequest->vet_id,
                        'user_id'       =>  $user->id,
                        'pet_id'        =>  $iPetID,
                        'created_at'    =>  Carbon::now()
                    )
                );

                array_push($vets, $petRequest->vet_id);

            }

        }

    }


    public function getRemovePet($petId)
    {
        $this->petRepository->setUser($this->authUser);
        $this->petRepository->delete($petId);
        $this->petRequestRepository->removeByPetId($petId);
        $this->sensorReadingRepository->removeByPetId($petId);
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
                //return redirect()->route('user.dashboard');
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
        $user = $this->authUser;
        $this->petRepository->setUser($this->authUser);
        $requests = $this->petRequestRepository->getAllByUserId($user->id);
        $pets = $this->petRepository->all();
        $vets = $this->vetRepository->all();
        if($this->authUser->pets->isEmpty()) {
            return redirect()->route('user.dashboard')
                ->with('error', Lang::get('general.You must create a pet before you can perform this function.'));
        }
        return View::make('user.vet')
            ->with(
                array(
                    'pets' => $pets,
                    'vets' => $vets,
                    'requests' => $requests
                ));
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
        $userid = $this->authUser->id;
        $this->petRepository->setUser($this->authUser);
        $pets = $this->petRepository->all();
        foreach ($pets as $pet) {
            if ($this->petRequestRepository->getByVetAndPetId($vetId, $pet->id) == null) {
                $data = array(
                    'vet_id' => $vetId,
                    'user_id' => $userid,
                    'pet_id' => $pet->id,
                    'approved' => 1
                );
                $this->petRequestRepository->create($data);
            }
            else {
                continue;
            }

        }
        return redirect()->route('user.dashboard.vet')
            ->with('success', Lang::get('general.Vet added'));
    }

    public function getRemoveVet($vetId)
    {
        $user = $this->authUser;
        if ($this->petRequestRepository->removeByVetAndUserId($vetId, $user->id)) {
            return redirect()->route('user.dashboard.vet')
                ->with('success', Lang::get('general.Vet removed'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function getActivatepet($id)
    {
        if ($this->petRequestRepository->update($id, array('approved' => 1))) {
            return redirect()->route('user.dashboard.vet')
                ->with('success', Lang::get('general.Pet activated'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function getDeactivatepet($id)
    {
        if ($this->petRequestRepository->update($id, array('approved' => 0))) {
            return redirect()->route('user.dashboard.vet')->with('success', Lang::get('general.Pet deactivated'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function postAssign($petId)
    {
        $this->petRepository->setUser($this->authUser);
        $newPetId = Input::get('pet-id');
        $query = $this->petRepository->get($petId);
        $data['microchip_number'] = $query->microchip_number;

        if ($this->petRepository->update($newPetId, $data)) {
            $this->petRepository->delete($petId);
            $sensorReading = $this->sensorReadingRepository->getByPetId($petId);
            if (!empty($sensorReading)) {
                $this->sensorReadingRepository->update($sensorReading->id, array('pet_id' => $newPetId));
            }
        }

        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.Pet microchip number assigned'));

    }

}
