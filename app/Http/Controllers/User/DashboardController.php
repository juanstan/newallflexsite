<?php namespace App\Http\Controllers\User;

use App\Models\Entities\Animal;
use App\Models\Entities\AnimalCondition;
use App\Models\Entities\User;
use App\Models\Entities\SensorReading;
use App\Models\Entities\SensorReadingSymptom;
use App\Models\Entities\Breed;
use App\Models\Entities\Animal\Request;
use App\Models\Entities\Help;
use App\Models\Entities\Vet;
use App\Models\Entities\Symptom;
use App\Models\Entities\Condition;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalReadingSymptomRepositoryInterface;
use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class DashboardController extends \App\Http\Controllers\Controller
{

    protected $userRepository;
    protected $animalRepository;
    protected $animalReadingRepository;
    protected $animalReadingSymptomRepository;

    public function __construct(UserRepositoryInterface $userRepository, VetRepositoryInterface $vetRepository, AnimalRepositoryInterface $animalRepository, AnimalReadingRepositoryInterface $animalReadingRepository, AnimalReadingSymptomRepositoryInterface $animalReadingSymptomRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->vetRepository = $vetRepository;
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
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
        $this->animalRepository->setUser($this->authUser);
        $symptoms = Symptom::all();
        $conditions = Condition::all();
        $animals = $this->animalRepository->all();
        $breed = Breed::all()->lists('name', 'id');
        if ($this->authUser->confirmed != null) {
            return \View::make('user.dashboard')->with(array('animals' => $animals, 'conditions' => $conditions, 'symptoms' => $symptoms, 'breed' => $breed));
        } else {
            return \View::make('user.dashboard')->with(array('not-verified' => '', 'animals' => $animals, 'conditions' => $conditions, 'symptoms' => $symptoms, 'breed' => $breed));
        }
    }

    public function getHelp()
    {
        $help = Help::all();
        return \View::make('user.help')->with(array('help' => $help));
    }

    public function getResult($id)
    {
        $help = Help::where('id', '=', $id)->get();
        return \View::make('user.result')->with(array('help' => $help));
    }

    public function postInvite()
    {
        \Mail::send('emails.vet-verify',
            array(
                'confirmation_code' => $this->authUser->confirmation_code
            ),
            function ($message) {
                $message->to(\Input::get('email'))
                    ->subject($this->authUser->name, 'has invited you to use All Flex');
            });
        return \Redirect::route('user.dashboard')
            ->with('message', \Lang::get('general.Verification email sent'));
    }

    public function postResetAverageTemperature($id)
    {
        if (SensorReading::where('animal_id', '=', $id)->update(array('average' => 0))) {
            return \Redirect::route('user.dashboard')->with('success', \Lang::get('general.Average temperature reset'));
        }
        return \Redirect::route('user.dashboard')->with('error', \Lang::get('general.There was a problem with your request'));
    }

    public function getSettings()
    {
        return \View::make('user.settings');
    }

    public function postSettings()
    {
        $id = $this->authUser->id;
        $validator = $this->userRepository->getUpdateValidator(\Input::all(), $id);
        if ($validator->fails())
        {
            return \Redirect::route('user.dashboard.settings')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        if (\Input::has('old_password'))
        {
            $password = \Input::get('old_password');
            if (!\Hash::check($password, $this->authUser->password))
            {
                return \Redirect::route('user.dashboard.settings')
                    ->with('error', \Lang::get('general.Password incorrect'));
            }
        }

        $input = \Input::only(array(
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
        if ($input['image_path'] != '') {
            $destinationPath = 'uploads/users/' . $id;
            if (!\File::exists($destinationPath))
            {
                \File::makeDirectory($destinationPath);
            }
            $extension = \Input::file('image_path')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $height = \Image::make(\Input::file('image_path'))->height();
            $width = \Image::make(\Input::file('image_path'))->width();
            if ($width > $height)
            {
                \Image::make(\Input::file('image_path'))->crop($height, $height)->save($destinationPath . '/' . $fileName);
            } else
            {
                \Image::make(\Input::file('image_path'))->crop($width, $width)->save($destinationPath . '/' . $fileName);
            }
            $input['image_path'] = 'uploads/users/' . $id . '/' . $fileName;
        }
        else
        {
            $input['image_path'] = $this->authUser->image_path;
        }
        if ($this->userRepository->update($this->authUser->id, $input) == false) {
            \App::abort(500);
        }
        return \Redirect::route('user.dashboard')->with('success', \Lang::get('general.Settings updated'));


    }

    public function postUpdatePet($id)
    {
        $this->animalRepository->setUser($this->authUser);
        if(Breed::where('name', '=', \Input::get('breed_id'))->first())
        {
            $breed_id = Breed::where('name', '=', \Input::get('breed_id'))->first();
            \Input::merge(array('breed_id' => $breed_id->id));
        }
        else
        {
            $breed_wildcard = \Input::get('breed_id');
            \Input::merge(array('breed_wildcard' => $breed_wildcard));
        }
        if($this->authUser->weight_units == "LBS") {

            $weight = round(\Input::get('weight') * 0.453592, 1);
            \Input::merge(array('weight' => $weight));

        }
        $input = \Input::all();
        $validator = $this->animalRepository->getUpdateValidator($input);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        if ($this->animalRepository->update($id, $input) == false) {
            \App::abort(500);
        }
        $animal = $this->animalRepository->get($id);
        $id = $this->authUser->id;
        if ($animal->vet_id != null) {
            Request::insert(
                ['vet_id' => $animal->vet_id, 'user_id' => $id, 'animal_id' => $animal->id, 'approved' => 1]
            );
        }
        return \Redirect::route('user.dashboard')->with('success', \Lang::get('general.Pet updated'));
    }

    public function postAddConditions($id)
    {
        $this->animalRepository->setUser($this->authUser);
        $input = \Input::get('conditions');
        if (is_array($input)) {
            AnimalCondition::where('animal_id', '=', $id)->delete();
            foreach ($input as $input) {

                $animalCondition = AnimalCondition::where(['animal_id' => $id, 'condition_id' => $input])->first();
                if (empty($animalCondition)) {
                    $animalCondition = new AnimalCondition;
                    $animalCondition->condition_id = $input;
                    $animalCondition->animal_id = $id;
                    $animalCondition->save();
                }
            }
            return \Redirect::route('user.dashboard')->with('message', \Lang::get('general.Conditions updated'));
        }
        return \Redirect::route('user.dashboard');
    }

    public function postAddSymptoms($id)
    {
        $this->animalRepository->setUser($this->authUser);
        $input = \Input::get('symptoms');
        if (is_array($input)) {
            SensorReadingSymptom::where('reading_id', '=', $id)->delete();
            foreach ($input as $input) {
                $readingSymptom = SensorReadingSymptom::where(['reading_id' => $id, 'symptom_id' => $input])->first();
                if (empty($readingSymptom)) {
                    $readingSymptom = new SensorReadingSymptom;
                    $readingSymptom->symptom_id = $input;
                    $readingSymptom->reading_id = $id;
                    $readingSymptom->save();
                }
            }
            return \Redirect::route('user.dashboard')->with('message', \Lang::get('general.Symptoms updated'));
        }
        return \Redirect::route('user.dashboard');
    }

    public function getSymptomRemove($reading_id, $id)
    {
        if (SensorReadingSymptom::where('reading_id', '=', $reading_id)->where('symptom_id', '=', $id)->delete()) {
            return \Redirect::route('user.dashboard')->with('success', \Lang::get('general.Symptom removed'));
        }
        return \Redirect::route('user.dashboard')->with('error', \Lang::get('general.There was a problem with your request'));
    }

    public function postUpdatePetPhoto($id)
    {

        $this->animalRepository->setUser($this->authUser);
        $userid = $this->authUser->id;
        $file = array('image' => \Input::file('pet-photo'));
        $rules = array('image' => '');
        $validator = \Validator::make($file, $rules);

        if ($validator->fails())
        {
            return \Redirect::route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        else
        {

            $destinationPath = 'uploads/pets/' . $userid;
            if (!\File::exists($destinationPath))
            {
                \File::makeDirectory($destinationPath);
            }

            $extension = \Input::file('pet-photo')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;

            $height = \Image::make(\Input::file('pet-photo'))->height();
            $width = \Image::make(\Input::file('pet-photo'))->width();

            if ($width > $height) {
                \Image::make(\Input::file('pet-photo'))->crop($height, $height)->save($destinationPath . '/' . $fileName);
            } else {
                \Image::make(\Input::file('pet-photo'))->crop($width, $width)->save($destinationPath . '/' . $fileName);
            }

            $input['image_path'] = '/uploads/pets/' . $userid . '/' . $fileName;
            $animal = $this->animalRepository->update($id, $input);
            return \Redirect::route('user.dashboard')->with('success', \Lang::get('general.Pet updated'));

        }

    }

    public function postCreatePet()
    {
        $this->animalRepository->setUser($this->authUser);
        if(Breed::where('name', '=', \Input::get('breed_id'))->first())
        {
            $breed_id = Breed::where('name', '=', \Input::get('breed_id'))->first();
            \Input::merge(array('breed_id' => $breed_id->id));
        }
        else
        {
            $breed_wildcard = \Input::get('breed_id');
            \Input::merge(array('breed_wildcard' => $breed_wildcard));
        }

        $input = \Input::all();
        $validator = $this->animalRepository->getCreateValidator($input);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')
                ->withErrors($validator);
        }
        $id = $this->authUser->id;
        $file = array('image' => \Input::file('pet-photo'));
        $rules = array('image' => 'max:4000|mimes:jpeg,png');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')->withInput()
                ->withErrors($validator);
        } else {
            if (\Input::hasFile('pet-photo')) {
                $destinationPath = 'uploads/pets/' . $id;
                if (!\File::exists($destinationPath)) {
                    \File::makeDirectory($destinationPath);
                }
                $extension = \Input::file('pet-photo')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $height = \Image::make(\Input::file('pet-photo'))->height();
                $width = \Image::make(\Input::file('pet-photo'))->width();
                if ($width > $height) {
                    \Image::make(\Input::file('pet-photo'))->crop($height, $height)->save($destinationPath . '/' . $fileName);
                } else {
                    \Image::make(\Input::file('pet-photo'))->crop($width, $width)->save($destinationPath . '/' . $fileName);
                }
                $input['image_path'] = '/uploads/pets/' . $id . '/' . $fileName;
                $animal = $this->animalRepository->create($input);
                return \Redirect::route('user.dashboard');
            }

            $animal = $this->animalRepository->create($input);
        }
        if ($animal == null) {
            \App::abort(500);
        }
        return \Redirect::route('user.dashboard');
    }

    public function getRemovePet($id)
    {
        $this->animalRepository->setUser($this->authUser);
        $this->animalRepository->delete($id);
        Request::where('animal_id', '=', $id)->delete();
        SensorReading::where('animal_id', '=', $id)->delete();
        return \Redirect::route('user.dashboard')->with('message', \Lang::get('general.Pet deleted'));
    }

    public function postReadingUpload()
    {

        $id = $this->authUser->id;
        $file = array('file' => \Input::file('file'));
        $rules = array('file' => 'required|max:4000');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')->withInput()
                ->withErrors($validator);
        } else {
            if (\Input::file('file')->isValid()) {
                $destinationPath = 'uploads/csv/' . \Crypt::encrypt($id);
                if (!\File::exists($destinationPath)) {
                    \File::makeDirectory($destinationPath);
                }
                $extension = \Input::file('file')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                \Input::file('file')->move($destinationPath, $fileName);
                $csv = Reader::createFromFileObject(new \SplFileObject($destinationPath . '/' . $fileName));
                $topRow = $csv->fetchOne(0);
                $reading_device_id = $topRow[0];
                $device_current_time_epoch = $topRow[4];
                $device_current_time = new \DateTime("@$device_current_time_epoch");
                function decoded_microchip_id($coded_string)
                {
                    $bin = base_convert($coded_string, 16, 2);
                    $manufacturer = substr($bin, 0, 10);
                    $device_id = substr($bin, 10, 38);
                    $manufacturer = bindec($manufacturer);
                    $device_id = bindec($device_id);
                    return $manufacturer . '.' . $device_id;
                }

                function reading_timestamp($device_current_time_epoch, $epoch)
                {
                    $epoch = $device_current_time_epoch - $epoch;
                    return new \DateTime("@$epoch");
                }

                ;
                function reading_temperature_c($temperature)
                {
                    return ($temperature * 0.112) + 23.3;
                }

                ;
                function reading_temperature_f($temperature)
                {
                    return ($temperature * 0.202) + 73.9;
                }

                ;
                $csv->setOffset(1);
                $data = $csv->query();
                foreach ($data as $lineIndex => $row) {
                    $profile = SensorReading::where(['reading_id' => $row[0], 'microchip_id' => decoded_microchip_id($row[1])])->first();
                    $animal = Animal::where(['microchip_number' => decoded_microchip_id($row[1])])->first();
                    if (empty($animal)) {
                        $animal = new animal();
                        $animal->microchip_number = decoded_microchip_id($row[1]);
                        $animal->user_id = $this->authUser->id;
                        $animal->save();
                    }
                    if (empty($animal->user_id)) {
                        $animal->user_id = $this->authUser->id;
                        $animal->save();
                    }
                    if (empty($profile)) {
                        $reading = new SensorReading();
                        $reading->reading_id = $row[0];
                        $reading->microchip_id = decoded_microchip_id($row[1]);
                        $reading->temperature = reading_temperature_c($row[2]);
                        $reading->device_id = $reading_device_id;
                        $reading->animal_id = $animal->id;
                        $reading->average = 1;
                        $reading->reading_time = reading_timestamp($device_current_time_epoch, $row[3]);
                        $reading->save();
                    }
                }
                return \Redirect::route('user.dashboard');
            } else {
                return \Redirect::route('user.dashboard')
                    ->with('error', \Lang::get('general.Uploaded file is not valid'));
            }
        }
    }

    public function getVet()
    {
        $id = $this->authUser->id;
        $this->animalRepository->setUser($this->authUser);
        $requests = Request::where('user_id', '=', $id)->get();
        $animals = $this->animalRepository->all();
        $vets = Vet::all();
        if($this->authUser->animals->isEmpty()) {
            return \Redirect::route('user.dashboard')->with('error', \Lang::get('general.You must create a pet before you can perform this function.'));
        }
        return \View::make('user.vet')->with(array('pets' => $animals, 'vets' => $vets, 'requests' => $requests));
    }

    public function getVetSearch()
    {

        $term = \Input::get('term');
        $vets = Vet::all();
        $result = [];
        foreach($vets as $vet) {
            if(strpos($vet->company_name, $term) !== false) {
                $result[] = ['id' => $vet->id, 'company_name' => $vet->company_name, 'city' => $vet->city, 'image_path' => $vet->image_path];
            }
        }
        return \Response::json($result);

    }

    public function getVetSearchLocation()
    {
        $location = \Input::get('term');
        $distance_set = '10';
        $data_arr = geocode($location);

        $coordA   = \Geotools::coordinate([$data_arr[0], $data_arr[1]]);
        $vets = Vet::all();
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
            return \Response::json(['error' => true, 'message' => 'There are no vets in this area']);
        }

        return \Response::json($result);

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
        return \Redirect::route('user.dashboard.vet')->with('success', \Lang::get('general.Vet added'));
    }

    public function getRemoveVet($id)
    {
        $userid = $this->authUser->id;
        if (Request::where('user_id', '=', $userid)->where('vet_id', '=', $id)->delete()) {
            return \Redirect::route('user.dashboard.vet')->with('success', \Lang::get('general.Vet removed'));
        }
        return \Redirect::route('user.dashboard.vet')->with('error', \Lang::get('general.There was a problem with your request'));
    }

    public function getActivatepet($id)
    {
        if (Request::where('animal_request_id', '=', $id)->update(array('approved' => 1))) {
            return \Redirect::route('user.dashboard.vet')->with('success', \Lang::get('general.Pet activated'));
        }
        return \Redirect::route('user.dashboard.vet')->with('error', \Lang::get('general.There was a problem with your request'));
    }

    public function getDeactivatepet($id)
    {
        if (Request::where('animal_request_id', '=', $id)->update(array('approved' => 0))) {
            return \Redirect::route('user.dashboard.vet')->with('success', \Lang::get('general.Pet deactivated'));
        }
        return \Redirect::route('user.dashboard.vet')->with('error', \Lang::get('general.There was a problem with your request'));
    }

    public function postAssign($id)
    {
        $input = \Input::get('pet-id');
        $query = Animal::where('id', '=', $id)->first();
        if (Animal::where('id', $input)->update(array('microchip_number' => $query->microchip_number))) {
            Animal::where('id', '=', $id)->delete();
            SensorReading::where('animal_id', '=', $id)->update(array('animal_id' => $input));
        }
        return \Redirect::route('user.dashboard')
            ->with('success', \Lang::get('general.Pet microchip number assigned'));
    }

}
