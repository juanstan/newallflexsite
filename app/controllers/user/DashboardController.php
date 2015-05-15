<?php namespace User;

use Entities\Animal;
use Entities\AnimalCondition;
use Entities\User;
use Entities\SensorReading;
use Entities\SensorReadingSymptom;
use Entities\Breed;
use Entities\Help;
use Entities\Symptom;
use Entities\Condition;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\UserRepositoryInterface;
use Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class DashboardController extends \BaseController
{

    protected $user;
    protected $repository;
    protected $rrepository;
    protected $srepository;

    public function __construct(UserRepositoryInterface $user, VetRepositoryInterface $vet, AnimalRepositoryInterface $repository, AnimalReadingRepositoryInterface $rrepository, AnimalReadingSymptomRepositoryInterface $srepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->user = $user;
        $this->vet = $vet;
        $this->rrepository = $rrepository;
        $this->repository = $repository;
        $this->srepository = $srepository;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth',
            array(
                'only' =>
                    array(
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

    public function getIndex()
    {
        $this->repository->setUser($this->authUser);
        $symptoms = Symptom::all();
        $conditions = Condition::all();
        $animals = $this->repository->all();
        $breed = Breed::all()->lists('name', 'id');
        if (\Auth::user()->get()->confirmed != null) {
            return \View::make('user.dashboard')->with(array('animals' => $animals, 'conditions' => $conditions, 'symptoms' => $symptoms, 'breed' => $breed));
        } else {
            \Session::flash('not-verified', '');
            return \View::make('user.dashboard')->with(array('animals' => $animals, 'conditions' => $conditions, 'symptoms' => $symptoms, 'breed' => $breed));
        }
    }

    public function getHelp()
    {
        $help = \DB::table('help')->get();
        return \View::make('user.help')->with(array('help' => $help));
    }

    public function getResult($id)
    {
        $help = \DB::table('help')->where('id', '=', $id)->get();
        return \View::make('user.result')->with(array('help' => $help));
    }

    public function postInvite()
    {
        \Mail::send('emails.vet-verify',
            array(
                'confirmation_code' => \Auth::vet()->get()->confirmation_code
            ),
            function ($message) {
                $message->to(\Input::get('email_address'))
                    ->subject(\Auth::user()->get()->name, 'has invited you to use All Flex');
            });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::route('user.dashboard');
    }

    public function postResetAverageTemperature($id)
    {
        if (\DB::table('sensor_readings')->where('animal_id', '=', $id)->update(array('average' => 0))) {
            return \Redirect::route('user.dashboard')->with('success', 'Average temperature reset');
        }
        return \Redirect::route('user.dashboard')->with('error', 'There was a problem with your request');
    }

    public function getSettings()
    {
        return \View::make('user.settings');
    }

    public function postSettings()
    {
        $input = \Input::all();
        $id = \Auth::user()->get()->id;
        $validator = $this->user->getUpdateValidator($input, $id);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard.settings')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }
        if (\Input::hasFile('image_path')) {
            $destinationPath = 'uploads/users/' . $id;
            if (!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }
            $extension = \Input::file('image_path')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $height = \Image::make(\Input::file('image_path'))->height();
            $width = \Image::make(\Input::file('image_path'))->width();
            if ($width > $height) {
                \Image::make(\Input::file('image_path'))->crop($height, $height)->save($destinationPath . '/' . $fileName);
            } else {
                \Image::make(\Input::file('image_path'))->crop($width, $width)->save($destinationPath . '/' . $fileName);
            }
            $image_path = 'uploads/users/' . $id . '/' . $fileName;
        } else {
            $image_path = $this->authUser->image_path;
        }
        $input = array_merge($input, array('image_path' => $image_path));
        if (\Input::has('password')) {
            $password = \Input::get('old_password');
            if (\Hash::check($password, $this->authUser->password)) {
                $input = array_merge($input, array('password' => \Input::get('password')));
            } else {
                \Session::flash('error', 'Password incorrect');
                return \Redirect::route('user.dashboard.settings');
            }
        }
        if ($this->user->update($this->authUser->id, $input) == false) {
            \App::abort(500);
        }
        return \Redirect::route('user.dashboard')->with('success', 'Settings updated');
    }

    public function postUpdatePet($id)
    {
        $this->repository->setUser($this->authUser);
        $breed_id = Breed::where('name', '=', \Input::get('breed_id'))->first();
        \Input::merge(array('breed_id' => $breed_id->id));
        if(\Auth::user()->get()->weight_units == "LBS") {

            $weight = round(\Input::get('weight') * 0.453592, 1);
            \Input::merge(array('weight' => $weight));

        }
        $input = \Input::all();
        $validator = $this->repository->getUpdateValidator($input);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        if ($this->repository->update($id, $input) == false) {
            \App::abort(500);
        }
        $animal = $this->repository->get($id);
        $id = \Auth::user()->get()->id;
        if ($animal->vet_id != null) {
            \DB::table('animal_requests')->insert(
                ['vet_id' => $animal->vet_id, 'user_id' => $id, 'animal_id' => $animal->id, 'approved' => 1]
            );
        }
        return \Redirect::route('user.dashboard')->with('success', 'Pet updated');
    }

    public function postAddConditions($id)
    {
        $this->repository->setUser($this->authUser);
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
            return \Redirect::route('user.dashboard')->with('message', 'Conditions updated');
        }
        return \Redirect::route('user.dashboard');
    }

    public function postAddSymptoms($id)
    {
        $this->repository->setUser($this->authUser);
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
            return \Redirect::route('user.dashboard')->with('message', 'Symptoms updated');
        }
        return \Redirect::route('user.dashboard');
    }

    public function getSymptomRemove($reading_id, $id)
    {
        if (\DB::table('sensor_reading_symptoms')->where('reading_id', '=', $reading_id)->where('symptom_id', '=', $id)->delete()) {
            return \Redirect::route('user.dashboard')->with('success', 'Symptom removed');
        }
        return \Redirect::route('user.dashboard')->with('error', 'There was a problem with your request');
    }

    public function postUpdatePetPhoto($id)
    {

        $this->repository->setUser($this->authUser);
        $userid = \Auth::user()->get()->id;
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
            $animal = $this->repository->update($id, $input);
            return \Redirect::route('user.dashboard')->with('success', 'Pet updated');

        }

        if ($this->repository->update($id, $input) == false) {
            \App::abort(500);
        }

    }

    public function postCreatePet()
    {
        $this->repository->setUser($this->authUser);
        $breed_id = Breed::where('name', '=', \Input::get('breed_id'))->first();
        \Input::merge(array('breed_id' => $breed_id->id));
        $input = \Input::all();
        $validator = $this->repository->getCreateValidator($input);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')
                ->withErrors($validator);
        }
        $id = \Auth::user()->get()->id;
        $file = array('image' => \Input::file('pet-photo'));
        $rules = array('image' => 'required|max:4000|mimes:jpeg,png');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::route('user.dashboard')->withInput()
                ->withErrors($validator);
        } else {
            if (\Input::file('pet-photo')->isValid()) {
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
                $animal = $this->repository->create($input);
                return \Redirect::route('user.dashboard');
            } else {
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::route('user.dashboard');
            }
        }
        if ($animal == null) {
            \App::abort(500);
        }
        return \Redirect::route('user.dashboard');
    }

    public function getRemovePet($id)
    {
        $this->repository->setUser($this->authUser);
        $this->repository->delete($id);
        \DB::table('animal_requests')->where('animal_id', '=', $id)->delete();
        \DB::table('sensor_readings')->where('animal_id', '=', $id)->delete();
        return \Redirect::route('user.dashboard')->with('message', 'Pet deleted');
    }

    public function postReadingUpload()
    {
        $input = \Input::all();
        $id = \Auth::user()->get()->id;
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
                        $animal->user_id = \Auth::user()->get()->id;
                        $animal->save();
                    }
                    if (empty($animal->user_id)) {
                        $animal->user_id = \Auth::user()->get()->id;
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
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::route('user.dashboard');
            }
        }
    }

    public function getVet()
    {
        $id = \Auth::user()->get()->id;
        $this->repository->setUser($this->authUser);
        $requests = \DB::table('animal_requests')->where('user_id', '=', $id)->get();
        $animals = $this->repository->all();
        $vets = \DB::table('vets')->get();
        return \View::make('user.vet')->with(array('pets' => $animals, 'vets' => $vets, 'requests' => $requests));
    }

    public function postVet()
    {
        $vetSearch = \Input::get('vet-search');
        $vets = \DB::table('vets')->where('company_name', 'LIKE', '%' . $vetSearch . '%')->get();
        var_dump('Search results');
        foreach ($vets as $vet) {
            var_dump($vet->company_name);
        }
    }

    public function getAddVet($id)
    {
        $userid = \Auth::user()->get()->id;
        $this->repository->setUser($this->authUser);
        $animals = $this->repository->all();
        foreach ($animals as $animal) {
            \DB::table('animal_requests')->insert(
                ['vet_id' => $id, 'user_id' => $userid, 'animal_id' => $animal->id, 'approved' => 1]
            );
        }
        return \Redirect::route('user.dashboard.vet')->with('success', 'Vet added');
    }

    public function getRemoveVet($id)
    {
        $userid = \Auth::user()->get()->id;
        if (\DB::table('animal_requests')->where('user_id', '=', $userid)->where('vet_id', '=', $id)->delete()) {
            return \Redirect::route('user.dashboard.vet')->with('success', 'Vet removed');
        }
        return \Redirect::route('user.dashboard.vet')->with('error', 'There was a problem with your request');
    }

    public function getActivatepet($id)
    {
        if (\DB::table('animal_requests')->where('animal_request_id', '=', $id)->update(array('approved' => 1))) {
            return \Redirect::route('user.dashboard.vet')->with('success', 'Pet activated');
        }
        return \Redirect::route('user.dashboard.vet')->with('error', 'There was a problem with your request');
    }

    public function getDeactivatepet($id)
    {
        if (\DB::table('animal_requests')->where('animal_request_id', '=', $id)->update(array('approved' => 0))) {
            return \Redirect::route('user.dashboard.vet')->with('success', 'Pet deactivated');
        }
        return \Redirect::route('user.dashboard.vet')->with('error', 'There was a problem with your request');
    }

}
