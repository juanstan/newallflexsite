<?php namespace Vet;

use Entities\Animal;
use Entities\Vet;
use Entities\SensorReading;
use Entities\SensorReadingSymptom;
use Entities\Symptom;
use Entities\Animal\Request;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class DashboardController extends \BaseController {

    protected $vetRepository;
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
        $this->beforeFilter('vetAuth',
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
            $this->animalRepository->setUser($this->authVet);
            $id = $this->authVet->id;
            $symptoms = Symptom::all();
            $requests = Request::where('vet_id', '=', $id)->get();
            $vet = $this->authVet;
            $pets = $this->animalRepository->all();
            if ($this->authVet->confirmed != null) {
                return \View::make('vet.dashboard')->with(array('pets' => $pets, 'symptoms' => $symptoms, 'requests' => $requests, 'vet' => $vet));
            }
            else {
                \Session::flash('not-verified', '');
                return \View::make('vet.dashboard')->with(array('pets' => $pets, 'symptoms' => $symptoms, 'requests' => $requests, 'vet' => $vet));
            }
    }

    public function getHelp() {

        $help = \DB::table('help')->get();
        return \View::make('vet.help')->with(array('help' => $help));

    }

    public function getResult($id) {

        $help = \DB::table('help')->where('id', '=', $id)->get();
        return \View::make('vet.result')->with(array('help' => $help));

    }

    public function postInvite() {

        \Mail::send('emails.vet-verify', array('confirmation_code' => $this->authVet->confirmation_code), function($message) {
            $message->to(\Input::get('email_address'))
                ->subject($this->authVet->name, 'has invited you to use All Flex');
        });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::route('vet.dashboard');
    }

    public function getPet($id) {
        $this->animalRepository->setUser($this->authVet);
        $Vetid = $this->authVet->id;
        $symptoms = Symptom::all();
        $pet = $this->animalRepository->get($id);
        if(Request::where('vet_id', '=', $id)->where('animal_id', '=', $id)->where('approved', '=', 1)->get())
        {
            return \View::make('vet.information')->with(array('pet' => $pet, 'symptoms' => $symptoms));
        }
        else
        {
            \Session::flash('not-verified', '');
            return \View::make('vet.dashboard')->with(array('pet' => $pet, 'symptoms' => $symptoms));
        }


        //return \View::make('vet.information')->with(array('pets' => $pets, 'symptoms' => $symptoms));
    }

    public function postResetAverageTemperature($id)
    {
        if(\DB::table('sensor_readings')->where('animal_id', '=', $id)->update(array('average' => 0)))
        {
            return \Redirect::route('user.dashboard')->with('success', 'Average temperature reset');
        }

        return \Redirect::route('user.dashboard')->with('error', 'There was a problem with your request');
    }

    public function getSettings()
    {
        return \View::make('vet.settings');
    }

    public function postSettings()
    {
        $id =  $this->authVet->id;
        $validator = $this->vetRepository->getUpdateValidator(\Input::all(), $id);
        if($validator->fails())
        {
            return \Redirect::route('vet.dashboard.settings')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        if (\Input::has('old_password'))
        {
            $password = \Input::get('old_password');
            if (!\Hash::check($password, $this->authVet->password))
            {
                \Session::flash('error', 'Password incorrect');
                return \Redirect::route('vet.dashboard.settings');
            }
        }

        $input = \Input::only(array(
            'company_name',
            'contact_name',
            'email_address',
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

            $input['image_path'] = '/uploads/vets/'.$id.'/'.$fileName;

        }
        else {

            $input['image_path'] = $this->authVet->image_path;

        }

        $address = \Input::get('address_1') . ' ' . \Input::get('address_2') . ' ' . \Input::get('city') . ' ' . \Input::get('county') . ' ' . \Input::get('zip');

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

        return \Redirect::route('vet.dashboard')->with('success', 'Settings updated');
    }

    public function postReadingUpload()
    {
        $input = \Input::all();
        $id = $this->authVet->id;
        $file = array('file' => \Input::file('file'));
        $rules = array('file' => 'required|max:4000');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::route('vet.register.reading')->withInput()
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
                    $profile = SensorReading::where(['reading_id' => $row[0], 'microchip_id' => decoded_microchip_id($row[1])])->first();
                    $animal = Animal::where(['microchip_number' => decoded_microchip_id($row[1])])->first();

                    if (empty($animal)) {
                        $animal = new animal();
                        $animal->microchip_number = decoded_microchip_id($row[1]);

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

                        $reading->vets()->attach($this->authVet);
                    }
                }
                return \Redirect::route('vet.register.reading');
            }
            else {
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::route('vet.register.reading');
            }
        }
    }


}
