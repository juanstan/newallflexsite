<?php namespace App\Http\Controllers\User;

use App\Models\Entities\Animal;
use App\Models\Entities\SensorReading;
use League\Csv\Reader;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;

class AnimalReadingRegisterController extends \App\Http\Controllers\Controller
{

    protected $authUser;
    protected $animalReadingRepository;
    protected $animalRepository;

    public function __construct(AnimalReadingRepositoryInterface $animalReadingRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->middleware('auth.user', array('only' => array('getIndex', 'postAssign', 'postFinish', 'getAssign', 'postAssign')));
    }

    public function getIndex()
    {
        return \View::make('usersignup.stage6');
    }

    public function postReadingUpload()
    {
        $input = \Input::all();
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
                    // Convert to binary
                    $bin = base_convert($coded_string, 16, 2);
                    // Split to 10/38 bits
                    $manufacturer = substr($bin, 0, 10);
                    $device_id = substr($bin, 10, 38);
                    // Convert to decimal
                    $manufacturer = bindec($manufacturer);
                    $device_id = bindec($device_id);
                    // Put pieces back
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

                return \Redirect::route('user.register.reading.assign');

            } else {
                return \Redirect::route('register.reading')
                    ->with('error', \Lang::get('general.Uploaded file is not valid'));
            }
        }
    }

    public function getAssign()
    {
        if (\Agent::isMobile()) {
            return \Redirect::route('user.dashboard');
        }
        $this->animalRepository->setUser($this->authUser);
        $pets = $this->animalRepository->all();
        return \View::make('usersignup.stage7')
            ->with(array('pets' => $pets));
    }

    public function postAssign($id)
    {
        $input = \Input::get('pet-id');
        $query = Animal::where('id', '=', $id)->first();
        if (Animal::where('id', $input)->update(array('microchip_number' => $query->microchip_number))) {
            Animal::where('id', '=', $id)->delete();
            SensorReading::where('animal_id', '=', $id)->update(array('animal_id' => $input));
        }
        return \Redirect::route('user.register.reading.assign')
            ->with('success', \Lang::get('general.Pet microchip number assigned'));


    }

    public function getFinish()
    {
        $confirmation_code = $this->authUser->confirmation_code;
        \Mail::send('emails.user-verify', array('confirmation_code' => $confirmation_code), function ($message) {
            $message->to($this->authUser->email, 'New user')
                ->subject('Verify your email address');
        });
        return \Redirect::route('user.dashboard');
    }

}