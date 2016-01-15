<?php namespace App\Models\Repositories;

use App\Models\Entities\User;
use App\Models\Entities\Pet;
use App\Http\Controllers\Vet;
use App\Models\Entities\Reading;
use App\Models\Entities\ReadingVet;
use App\Models\Entities\Pet\Request;
use League\Csv\Reader;

class PetReadingRepository extends AbstractRepository implements PetReadingRepositoryInterface
{
    protected $model;
    protected $pet;

    public function __construct(Reading $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        if($this->pet)
        {
            return $this->pet->readings()->orderBy('reading_time')->get();
        }

        return parent::all();
    }


    public function get($id)
    {
        if($id)
        {
            return $this->pet ? $this->pet->readings()->findOrFail($id) : parent::get($id);
        }

    }

    public function readingUploadVet($input, $vet)
    {

        $destinationPath = 'uploads/csv/' . \Crypt::encrypt($vet->id);
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
            $profile = Reading::where('microchip_id', '=', decoded_microchip_id($row[1]))->first();
            $pet = Pet::where(['microchip_number' => decoded_microchip_id($row[1])])->first();

            if (empty($pet)) {
                $pet = new pet();
                $pet->microchip_number = decoded_microchip_id($row[1]);
                //$pet->user_id = $user->id;

                $pet->save();
            }
            if (empty($profile)) {
                $reading = new Reading();
                $reading->microchip_id = decoded_microchip_id($row[1]);
                $reading->temperature = reading_temperature($row[2]);
                $reading->device_id = $reading_device_id;
                $reading->pet_id = $pet->id;
                $reading->average = 1;
                $reading->reading_time = reading_timestamp($device_current_time_epoch, $row[3]);

                $reading->save();

                $vetReading = new ReadingVet();
                $vetReading->reading_id = $reading->id;
                $vetReading->vet_id = $vet->id;
                $vetReading->save();

                $vetReading = new ReadingVet();
                $vetReading->reading_id = $reading->id;
                $vetReading->vet_id = $vet->id;
                $vetReading->save();

            }

            $vetRequest = new Request();
            $vetRequest->pet_id = $pet->id;
            $vetRequest->vet_id = $vet->id;
            $vetRequest->save();

        }

        return true;

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
        $data = $csv->fetch();

        foreach ($data as $lineIndex => $row) {
            $profile = Reading::where('microchip_id', '=', decoded_microchip_id($row[1]))->first();
            $petOwner = $user->pets()->checkMicrochip(decoded_microchip_id($row[1]))->first();
            $pet = Pet::checkMicrochip(decoded_microchip_id($row[1]))->first();

            if (!$petOwner && $pet) {
                throw new \Exception('The microchip has been already selected', 111);
                return false;
            }

            if (!$petOwner && !$pet) {
                //Saving the pet
                $pet = new pet();
                $pet->microchip_number = decoded_microchip_id($row[1]);
                $pet->user_id = $user->id;
                $pet->save();

            }elseif($petOwner) {
                $pet = $petOwner;

            }

            if (empty($profile)) {
                $reading = new Reading();
                $reading->microchip_id = decoded_microchip_id($row[1]);
                $reading->temperature = reading_temperature($row[2]);
                $reading->device_id = $reading_device_id;
                $reading->pet_id = $pet->id;
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

        $reading->pet()->associate($this->pet);

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

    public function setPet($pet)
    {
        $this->pet = $pet;

        return $this;
    }


    public function updateTimeout($input)
    {
        $this->created_at->addSeconds(30);

        return $this;
    }

    public function reassignReadings($pet_id, $newPetId)
    {
        if($pet_id && $newPetId)
        {
            SensorReading::where('pet_id' , $pet_id)->update(['pet_id' => $newPetId]);
        }
    }
}

?>
