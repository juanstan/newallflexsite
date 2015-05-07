<?php namespace User;

use Entities\Animal;
use Entities\SensorReading;
use League\Csv\Reader;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalRepositoryInterface;

class AnimalReadingRegisterController extends \BaseController
{

    protected $authUser;

    protected $repository;

    protected $arepository;

    public function __construct(AnimalReadingRepositoryInterface $repository, AnimalRepositoryInterface $arepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->repository = $repository;
        $this->arepository = $arepository;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getIndex', 'postAssign', 'postFinish', 'getAssign', 'postAssign')));
    }

    public function getIndex()
    {
        return \View::make('usersignup.stage6');
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
                    $profile = Reading::where(['reading_id' => $row[0], 'microchip_id' => decoded_microchip_id($row[1])])->first();
                    $animal = Animal::where(['microchip_number' => decoded_microchip_id($row[1])])->first();

                    if (empty($animal)) {
                        $animal = new animal();
                        $animal->microchip_number = decoded_microchip_id($row[1]);
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

                return \Redirect::route('user.register.reading.assign');

            } else {
                \Session::flash('error', 'uploaded file is not valid');
                return \Redirect::route('register.reading');
            }
        }
    }

    public function getAssign()
    {
        if (\Agent::isMobile()) {
            return \Redirect::route('user.dashboard');
        }
        $this->arepository->setUser($this->authUser);
        $pets = $this->arepository->all();
        return \View::make('usersignup.stage7')->with(array('pets' => $pets));
    }

    public function postAssign($id)
    {
        $input = \Input::get('pet-id');
        $query = \DB::table('animals')->where('id', '=', $id)->first();
        if (\DB::table('animals')->where('id', $input)->update(array('microchip_number' => $query->microchip_number))) {
            \DB::table('animals')->where('id', '=', $id)->delete();
            \DB::table('sensor_readings')->where('animal_id', '=', $id)->update(array('animal_id' => $input));
        }
        \Session::flash('success', 'Pet microchip number assigned');
        return \Redirect::route('user.register.reading.assign');


    }

    public function getFinish()
    {
        return \Redirect::route('user.dashboard');
    }

}
