<?php namespace App\Http\Controllers\User;

use View;
use Input;
use Lang;
use Auth;

use App\Models\Entities\Animal;
use App\Models\Entities\User;
use App\Models\Entities\Animal\Request;
use App\Models\Entities\Vet;

use App\Models\Repositories\AnimalRepository;
use App\Models\Repositories\AnimalReadingRepository;
use App\Models\Repositories\AnimalReadingSymptomRepository;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\VetRepository;
use App\Models\Repositories\PhotoRepository;
use App\Models\Repositories\SymptomRepository;
use App\Models\Repositories\ConditionRepository;
use App\Models\Repositories\BreedRepository;
use App\Models\Repositories\HelpRepository;
use App\Models\Repositories\SensorReadingRepository;
use App\Models\Repositories\AnimalConditionRepository;
use App\Models\Repositories\SensorReadingSymptomRepository;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    protected $userRepository;
    protected $animalRepository;
    protected $animalReadingRepository;
    protected $animalReadingSymptomRepository;
    protected $photoRepository;
    protected $symptomRepository;
    protected $conditionRepository;
    protected $breedRepository;
    protected $helpRepository;
    protected $sensorReadingRepository;
    protected $animalConditionRepository;
    protected $sensorReadingSymptomRepository;

    public function __construct(
        UserRepository $userRepository,
        VetRepository $vetRepository,
        AnimalRepository $animalRepository,
        AnimalReadingRepository $animalReadingRepository,
        AnimalReadingSymptomRepository
        $animalReadingSymptomRepository,
        PhotoRepository $photoRepository,
        SymptomRepository $symptomRepository,
        ConditionRepository $conditionRepository,
        BreedRepository $breedRepository,
        HelpRepository $helpRepository,
        SensorReadingRepository $sensorReadingRepository,
        AnimalConditionRepository $animalConditionRepository,
        SensorReadingSymptomRepository $sensorReadingSymptomRepository
    )

    {
        $this->authUser = Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->vetRepository = $vetRepository;
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
        $this->photoRepository = $photoRepository;
        $this->symptomRepository = $symptomRepository;
        $this->conditionRepository = $conditionRepository;
        $this->breedRepository = $breedRepository;
        $this->helpRepository = $helpRepository;
        $this->sensorReadingRepository = $sensorReadingRepository;
        $this->animalConditionRepository = $animalConditionRepository;
        $this->sensorReadingSymptomRepository = $sensorReadingSymptomRepository;

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
        $this->animalRepository->setUser($user);
        $symptoms = $this->symptomRepository->all();
        $conditions = $this->conditionRepository->all();
        $animals = $this->animalRepository->all();
        $breed = $this->breedRepository->all()->lists('name', 'id');

        if ($this->authUser->confirmed != null) {
            return View::make('user.dashboard')->with(
                array(
                    'animals' => $animals,
                    'conditions' => $conditions,
                    'symptoms' => $symptoms,
                    'breed' => $breed,
                    'user' => $user
                ));
        } else {
            return View::make('user.dashboard')
                ->with(
                    array(
                        'not-verified' => '',
                        'animals' => $animals,
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
                $message->to(Input::get('email'))
                    ->subject($this->authUser->name, 'has invited you to use All Flex');
            });
        return redirect()->route('user.dashboard')
            ->with('message', Lang::get('general.Verification email sent'));
    }

    public function postResetAverageTemperature($id)
    {
        $animal = $this->sensorReadingRepository->getByAnimalId($id);
        if ($this->sensorReadingRepository->update($animal->id, array('average' => 0))) {
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

        $input = Input::only(array(
            'email',
            'first_name',
            'last_name',
            'image_path',
            'password',
        ));

        if($input['password'] == '')
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
        $this->animalRepository->setUser($user);
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
        $validator = $this->animalRepository->getUpdateValidator($input);
        if ($validator->fails()) {
            return redirect()->route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        if ($this->animalRepository->update($id, $input) == false) {
            \App::abort(500);
        }
        $animal = $this->animalRepository->get($id);
        $userId = $user->id;
        if ($animal->vet_id != null) {
            Request::insert(
                ['vet_id' => $animal->vet_id, 'user_id' => $userId, 'animal_id' => $animal->id, 'approved' => 1]
            );
        }
        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.Pet updated'));
    }

    public function postAddConditions($animalId)
    {
        $this->animalRepository->setUser($this->authUser);
        $conditions = Input::get('conditions');
        if (is_array($conditions)) {
            $this->animalConditionRepository->removeAndUpdateConditions($animalId, $conditions);
            return redirect()->route('user.dashboard')
                ->with('message', Lang::get('general.Conditions updated'));
        }
        return redirect()->route('user.dashboard');
    }

    public function postAddSymptoms($readingId)
    {
        $this->animalRepository->setUser($this->authUser);
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
        $this->animalRepository->setUser($user);
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

        $this->animalRepository->update($id, $input);

        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.Pet updated'));

    }

    public function postCreatePet()
    {
        $input = Input::all();
        $user = $this->authUser;
        $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);

        $this->animalRepository->setUser($user);

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

        $validator = $this->animalRepository->getCreateValidator($input);

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

        $animal = $this->animalRepository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return redirect()->route('user.dashboard');
    }

    public function getRemovePet($animalId)
    {
        $this->animalRepository->setUser($this->authUser);
        $this->animalRepository->delete($animalId);
        Request::where('animal_id', '=', $id)->delete();
        $this->sensorReadingRepository->removeByAnimalId($animalId);
        return redirect()->route('user.dashboard')
            ->with('message', Lang::get('general.Pet deleted'));
    }

    public function postReadingUpload()
    {
        $input = Input::all();
        $user = $this->authUser;

        $readingValidator = $this->animalReadingRepository->getReadingUploadValidator($input);
        if ($readingValidator->fails()) {
            return redirect()->back()
                ->withErrors($readingValidator)
                ->withInput();
        }

        if($this->animalReadingRepository->readingUpload($input, $user))
        {
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('register.reading')
            ->with('error', Lang::get('general.Uploaded file is not valid'));

    }

    public function getVet()
    {
        $id = $this->authUser->id;
        $this->animalRepository->setUser($this->authUser);
        $requests = Request::where('user_id', '=', $id)->get();
        $animals = $this->animalRepository->all();
        $vets = $this->vetRepository->all();
        if($this->authUser->animals->isEmpty()) {
            return redirect()->route('user.dashboard')
                ->with('error', Lang::get('general.You must create a pet before you can perform this function.'));
        }
        return View::make('user.vet')
            ->with(
                array(
                    'pets' => $animals,
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

    public function getAddVet($id)
    {
        $userid = $this->authUser->id;
        $this->animalRepository->setUser($this->authUser);
        $animals = $this->animalRepository->all();
        foreach ($animals as $animal) {
            if (Request::where('vet_id', $id)->where('animal_id', $animal->id)->first() == null) {
                Request::insert(
                    ['vet_id' => $id, 'user_id' => $userid, 'animal_id' => $animal->id, 'approved' => 1]
                );
            }
            else {
                continue;
            }

        }
        return redirect()->route('user.dashboard.vet')->with('success', Lang::get('general.Vet added'));
    }

    public function getRemoveVet($id)
    {
        $userid = $this->authUser->id;
        if (Request::where('user_id', '=', $userid)->where('vet_id', '=', $id)->delete()) {
            return redirect()->route('user.dashboard.vet')
                ->with('success', Lang::get('general.Vet removed'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function getActivatepet($id)
    {
        if (Request::where('animal_request_id', '=', $id)->update(array('approved' => 1))) {
            return redirect()->route('user.dashboard.vet')
                ->with('success', Lang::get('general.Pet activated'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function getDeactivatepet($id)
    {
        if (Request::where('animal_request_id', '=', $id)->update(array('approved' => 0))) {
            return redirect()->route('user.dashboard.vet')->with('success', Lang::get('general.Pet deactivated'));
        }
        return redirect()->route('user.dashboard.vet')
            ->with('error', Lang::get('general.There was a problem with your request'));
    }

    public function postAssign($animalId)
    {
        $newPetId = Input::get('pet-id');
        $query = $this->animalRepository->get($animalId);
        $data['microchip_number'] = $query->microchip_number;

        if ($this->animalRepository->update($newPetId, $data)) {
            $this->animalRepository->delete($animalId);
            $sensorReading = $this->sensorReadingRepository->getByAnimalId($animalId);
            $this->sensorReadingRepository->update($sensorReading->id, array('animal_id' => $newPetId));
        }
        return redirect()->route('user.dashboard')
            ->with('success', Lang::get('general.Pet microchip number assigned'));
    }

}
