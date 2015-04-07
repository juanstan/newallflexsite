<?php namespace Pet;

use Entities\Animal;
use Entities\User;
use Entities\Reading;
use Entities\Symptom;
use Entities\Help;
use Entities\SymptomNames;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\UserRepositoryInterface;
use Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class DashboardController extends \BaseController {

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
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('postResetAverageTemperature', 'getSettings', 'postSettings', 'postUpdatePet', 'postAddSymptoms', 'postUpdatePetPhoto', 'postCreatePet', 'getRemovePet', 'postReadingUpload')));

    }

    public function getIndex() {

        $this->repository->setUser($this->authUser);
        $symptoms = \DB::table('symptoms')->get();
        $pets = $this->repository->all();

        if (\Auth::user()->get()->confirmed != null) {
            return \View::make('pet.dashboard')->with(array('pets' => $pets, 'symptoms' => $symptoms));
        }
        else {
            \Session::flash('not-verified', '');
            return \View::make('pet.dashboard')->with(array('pets' => $pets, 'symptoms' => $symptoms));
        }

    }

    public function getHelp() {

        $help = \DB::table('help')->get();
        return \View::make('pet.help')->with(array('help' => $help));

    }

    public function getResult($id) {

        $help = \DB::table('help')->where('id', '=', $id)->get();
        return \View::make('pet.result')->with(array('help' => $help));

    }

    public function postInvite() {

        \Mail::send('emails.vet-verify', array('confirmation_code' => \Auth::vet()->get()->confirmation_code), function($message) {
            $message->to(\Input::get('email_address'))
                ->subject(\Auth::user()->get()->name, 'has invited you to use All Flex');
        });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::to('/pet/dashboard');
    }

    public function postResetAverageTemperature($id)
    {
        if(\DB::table('sensor_readings')->where('animal_id', '=', $id)->update(array('average' => 0)))
        {
            return \Redirect::to('pet/dashboard')->with('success', 'Average temperature reset');
        }

        return \Redirect::to('pet/dashboard')->with('error', 'There was a problem with your request');
    }

    public function getSettings()
    {
        return \View::make('pet.settings');
    }

    public function postSettings()
    {
        $input = \Input::all();
        $id =  \Auth::user()->get()->id;
        $validator = $this->user->getUpdateValidator($input, $id);

        if($validator->fails())
        {
            return \Redirect::to('pet/dashboard/settings')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        if (\Input::hasFile('image_path')){
            $destinationPath = 'images/uploads/'.$id;
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

            $image_path = '/images/uploads/'.$id.'/'.$fileName;

        }
        else {

            $image_path = $this->authUser->image_path;

        }

        $input = array_merge($input, array('image_path' => $image_path));

        if (\Input::has('password'))
        {
            $password = \Input::get('old_password');
            if(\Hash::check($password,$this->authUser->password))
            {
                $input = array_merge($input, array('password' => \Input::get('password')));
            }
            else
            {

                \Session::flash('error', 'Password incorrect');
                return \Redirect::to('pet/dashboard/settings');

            }
        }

        if($this->user->update($this->authUser->id, $input) == false)
        {
            \App::abort(500);
        }

        return \Redirect::to('pet/dashboard')->with('success', 'Settings updated');
    }

    public function postUpdatePet($id) // PUT
    {
        $this->repository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->repository->getUpdateValidator($input);

        if($validator->fails())
        {
            return \Redirect::to('/pet/dashboard')->withInput()
                ->withErrors($validator);
        }
        if($this->repository->update($id, $input) == false)
        {
            \App::abort(500);
        }

        $pet = $this->repository->get($id);
        $id = \Auth::user()->get()->id;

        if($pet->vet_id != null)
        {
            \DB::table('animal_requests')->insert(
                ['vet_id' => $pet->vet_id, 'user_id' => $id, 'animal_id' => $pet->id, 'approved' => 1]
            );
        }

        return \Redirect::to('/pet/dashboard')->with('success', 'Pet updated');
    }

    public function postAddSymptoms($id) // PUT
    {
        $this->repository->setUser($this->authUser);

        $input = \Input::get('symptoms');

        if(is_array($input))
        {
            foreach($input as $input)
            {
                $readingSymptom = Symptom::where(['reading_id' => $id, 'symptom_id' => $input])->first();
                if (empty($readingSymptom)) {
                    $readingSymptom = new Symptom;
                    $readingSymptom->symptom_id = $input;
                    $readingSymptom->reading_id = $id;
                    $readingSymptom->save();
                }
            }
            return \Redirect::to('/pet/dashboard')->with('message', 'Symptoms updated');
        }

        return \Redirect::to('/pet/dashboard');

    }

    public function getSymptomRemove($reading_id, $id) // PUT
    {

        if(\DB::table('sensor_reading_symptoms')->where('reading_id', '=', $reading_id)->where('symptom_id', '=', $id)->delete())
        {
            return \Redirect::to('pet/dashboard')->with('success', 'Symptom removed');
        }

        return \Redirect::to('pet/dashboard')->with('error', 'There was a problem with your request');

    }

    public function postUpdatePetPhoto($id) // PUT
    {
        $this->repository->setUser($this->authUser);

        $userid = \Auth::user()->get()->id;

        $file = array('image' => \Input::file('pet-photo'));
        $rules = array('image' => '');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::to('/pet/dashboard')->withInput()
                ->withErrors($validator);
        }
        else {
            if (\Input::file('pet-photo')->isValid()) {
                $destinationPath = 'images/uploads/'.$userid;
                if(!\File::exists($destinationPath)) {
                    \File::makeDirectory($destinationPath);
                }

                $extension = \Input::file('pet-photo')->getClientOriginalExtension();
                $fileName = rand(11111,99999).'.'.$extension;

                $height = \Image::make(\Input::file('pet-photo'))->height();
                $width = \Image::make(\Input::file('pet-photo'))->width();

                if($width > $height) {
                    \Image::make(\Input::file('pet-photo'))->crop($height, $height)->save($destinationPath.'/'.$fileName);
                }
                else {
                    \Image::make(\Input::file('pet-photo'))->crop($width, $width)->save($destinationPath.'/'.$fileName);
                }

                $input['image_path'] = '/images/uploads/'.$userid.'/'.$fileName;
                $animal = $this->repository->update($id, $input);
                return \Redirect::to('/pet/dashboard')->with('success', 'Pet updated');

            }
            else {
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::to('/pet/dashboard');
            }
        }

        if($this->repository->update($id, $input) == false)
        {
            \App::abort(500);
        }

    }

    public function postCreatePet()
    {
        $this->repository->setUser($this->authUser);
        $input = \Input::all();
        $validator = $this->repository->getCreateValidator($input);

        if($validator->fails())
        {
            return \Redirect::to('/pet/dashboard')
                ->withErrors($validator);
        }

        $id = \Auth::user()->get()->id;

        $file = array('image' => \Input::file('pet-photo'));
        $rules = array('image' => 'required|max:4000|mimes:jpeg,png');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::to('/pet/dashboard')->withInput()
                ->withErrors($validator);
        }
        else {
            if (\Input::file('pet-photo')->isValid()) {
                $destinationPath = 'images/uploads/'.$id;
                if(!\File::exists($destinationPath)) {
                    \File::makeDirectory($destinationPath);
                }

                $extension = \Input::file('pet-photo')->getClientOriginalExtension();
                $fileName = rand(11111,99999).'.'.$extension;

                $height = \Image::make(\Input::file('pet-photo'))->height();
                $width = \Image::make(\Input::file('pet-photo'))->width();

                if($width > $height) {
                    \Image::make(\Input::file('pet-photo'))->crop($height, $height)->save($destinationPath.'/'.$fileName);
                }
                else {
                    \Image::make(\Input::file('pet-photo'))->crop($width, $width)->save($destinationPath.'/'.$fileName);
                }

                $input['image_path'] = '/images/uploads/'.$id.'/'.$fileName;
                $animal = $this->repository->create($input);
                return \Redirect::to('/pet/dashboard');

            }
            else {
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::to('/pet/dashboard');
            }
        }

        if($animal == null)
        {
            \App::abort(500);
        }

        return \Redirect::to('/pet/dashboard');
    }

    public function getRemovePet($id) // PUT
    {
        $this->repository->setUser($this->authUser);
        $this->repository->delete($id);
        \DB::table('animal_requests')->where('animal_id', '=', $id)->delete();
        \DB::table('sensor_readings')->where('animal_id', '=', $id)->delete();
        return \Redirect::to('/pet/dashboard')->with('message', 'Pet deleted');
    }

    public function postReadingUpload()
    {
        $input = \Input::all();
        $id = \Auth::user()->get()->id;
        $file = array('file' => \Input::file('file'));
        $rules = array('file' => 'required|max:4000');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::to('/pet/dashboard')->withInput()
                ->withErrors($validator);
        }
        else {
            if (\Input::file('file')->isValid()) {
                $destinationPath = 'uploads/csv/'.\Crypt::encrypt($id);
                if(!\File::exists($destinationPath)) {
                    \File::makeDirectory($destinationPath);
                }
                $extension = \Input::file('file')->getClientOriginalExtension();
                $fileName = rand(11111,99999).'.'.$extension;

                \Input::file('file')->move($destinationPath, $fileName);

                $csv = Reader::createFromFileObject(new \SplFileObject($destinationPath.'/'.$fileName));

                $topRow = $csv->fetchOne(0);
                $reading_device_id = $topRow[0];
                $device_current_time_epoch = $topRow[4];
                $device_current_time = new \DateTime("@$device_current_time_epoch");

                function decoded_microchip_id($coded_string)
                {
                    // Convert to binary
                    $bin = base_convert($coded_string, 16, 2);
                    // Split to 10/38 bits
                    $manufacturer = substr($bin, 0, 10);
                    $device_id = substr($bin, 10, 38);
                    // Convert to decimal
                    $manufacturer = bindec($manufacturer);
                    $device_id = bindec($device_id);
                    // Put pieces back
                    return $manufacturer.'.'.$device_id;
                }

                function reading_timestamp($device_current_time_epoch, $epoch)
                {
                    $epoch = $device_current_time_epoch - $epoch;
                    return new \DateTime("@$epoch");
                };

                function reading_temperature_c($temperature)
                {
                    return ($temperature * 0.112) + 23.3;
                };
                function reading_temperature_f($temperature)
                {
                    return ($temperature * 0.202) + 73.9;
                };
                $csv->setOffset(1);
                $data = $csv->query();
                foreach ($data as $lineIndex => $row) {
                    $profile = Reading::where(['reading_id' => $row[0], 'microchip_id' => decoded_microchip_id($row[1])])->first();
                    $animal = Animal::where(['microchip_number' => decoded_microchip_id($row[1])])->first();

                    if (empty($animal)) {
                        $animal = new animal();
                        $animal->microchip_number = decoded_microchip_id($row[1]);
                        $animal->user_id = \Auth::user()->get()->id;

                        $animal->save();
                    }
                    if(empty($animal->user_id)) {
                        $animal->user_id = \Auth::user()->get()->id;
                        $animal->save();
                    }

                    if (empty($profile)) {
                        $reading = new Reading();
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

                return \Redirect::to('/pet/dashboard');

            }
            else {
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::to('/pet/dashboard');
            }
        }
    }

    public function getVet()
    {
        $id = \Auth::user()->get()->id;
        $this->repository->setUser($this->authUser);
        $requests = \DB::table('animal_requests')->where('user_id', '=', $id)->get();
        $pets = $this->repository->all();
        $vets = \DB::table('vets')->get();
        return \View::make('pet.vet')->with(array('pets' => $pets, 'vets' => $vets, 'requests' => $requests));
    }

    public function postVet()
    {
        $vetSearch = \Input::get('vet-search');

        $vets = \DB::table('vets')->where('company_name', 'LIKE', '%'.$vetSearch.'%')->get();

        var_dump('Search results');

        foreach($vets as $vet){
            var_dump($vet->company_name);
        }
    }

    public function getAddVet($id) // PUT
    {
        $userid = \Auth::user()->get()->id;
        $this->repository->setUser($this->authUser);
        $pets = $this->repository->all();
        foreach($pets as $pet)
        {
            \DB::table('animal_requests')->insert(
                ['vet_id' => $id, 'user_id' => $userid, 'animal_id' => $pet->id, 'approved' => 1]
            );
        }
        return \Redirect::to('pet/dashboard/vet')->with('success', 'Vet added');
    }

    public function getRemoveVet($id) // PUT
    {
        $userid = \Auth::user()->get()->id;
        if(\DB::table('animal_requests')->where('user_id', '=', $userid)->where('vet_id', '=', $id)->delete())
        {
            return \Redirect::to('pet/dashboard/vet')->with('success', 'Vet removed');
        }

        return \Redirect::to('pet/dashboard/vet')->with('error', 'There was a problem with your request');
    }

    public function getActivatepet($id) // PUT
    {
        if(\DB::table('animal_requests')->where('animal_request_id', '=', $id)->update(array('approved' => 1)))
        {
            return \Redirect::to('pet/dashboard/vet')->with('success', 'Pet activated');
        }

        return \Redirect::to('pet/dashboard/vet')->with('error', 'There was a problem with your request');
    }

    public function getDeactivatepet($id) // PUT
    {
        if(\DB::table('animal_requests')->where('animal_request_id', '=', $id)->update(array('approved' => 0)))
        {
            return \Redirect::to('pet/dashboard/vet')->with('success', 'Pet deactivated');
        }

        return \Redirect::to('pet/dashboard/vet')->with('error', 'There was a problem with your request');
    }



}
