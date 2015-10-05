<?php namespace App\Models\Repositories;

use App\Models\Entities\User;
use App\Models\Entities\Animal;
use App\Models\Entities\SensorReading;
use League\Csv\Reader;

class AnimalReadingRepository extends AbstractRepository implements AnimalReadingRepositoryInterface
{
    protected $classname = 'App\Models\Entities\SensorReading';

    protected $repository;
    
    protected $animal;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {             
        if($this->animal)
        {
            return $this->animal->sensorReadings()->orderBy('reading_time')->get();
        }

        return parent::all();
    }
    
    
    public function get($id)
    {
        if($id)
        {
            return $this->animal ? $this->animal->sensorReadings()->findOrFail($id) : parent::get($id);
        }

    }

    public function readingUpload($input, $user)
    {

            $destinationPath = 'uploads/csv/' . \Crypt::encrypt($user->id);
            if (!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }
            $extension = $input['file']->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;

            $input['file']->move($destinationPath, $fileName);

            $csv = Reader::createFromFileObject(new \SplFileObject($destinationPath . '/' . $fileName));

            $topRow = $csv->fetchOne(0);
            $reading_device_id = $topRow[0];
            $device_current_time_epoch = $topRow[4];

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

            function reading_temperature($temperature)
            {
                return ($temperature * 0.112) + 23.3;
            }

            $csv->setOffset(1);
            $data = $csv->query();
            foreach ($data as $lineIndex => $row) {
                $profile = SensorReading::where('microchip_id', '=', decoded_microchip_id($row[1]))->first();
                $animal = Animal::where(['microchip_number' => decoded_microchip_id($row[1])])->first();

                if (empty($animal)) {
                    $animal = new animal();
                    $animal->microchip_number = decoded_microchip_id($row[1]);
                    $animal->user_id = $user->id;

                    $animal->save();
                }
                if (empty($profile)) {
                    $reading = new SensorReading();
                    $reading->microchip_id = decoded_microchip_id($row[1]);
                    $reading->temperature = reading_temperature($row[2]);
                    $reading->device_id = $reading_device_id;
                    $reading->animal_id = $animal->id;
                    $reading->average = 1;
                    $reading->reading_time = reading_timestamp($device_current_time_epoch, $row[3]);

                    $reading->save();
                }

            }

        return true;

    }

    public function getReadingUploadValidator($input)
    {
        return \Validator::make($input,
            [
                'file' => ['required','max:4000'],
            ]);

    }

    public function create($input)
    {

            $reading = parent::create($input);

            $reading->animal()->associate($this->animal);

            $reading->save();


        return $reading;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'temperature' => ['required']
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'average' => ['sometimes','required'],
        ]);
    }
    
    public function setAnimal($animal)
    {
        $this->animal = $animal;

        return $this;
    }

    
    public function updateTimeout($input)
    {
        $this->created_at->addSeconds(30);

        return $this;
    }
   
}

?>
