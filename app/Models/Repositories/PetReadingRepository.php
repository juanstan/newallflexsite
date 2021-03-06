<?php namespace App\Models\Repositories;

use App\Models\Entities\User;
use App\Models\Entities\Pet;
use App\Models\Entities\Device;
use App\Http\Controllers\Vet;
use App\Models\Entities\Reading;
use Faker\Provider\zh_TW\DateTime;
use League\Csv\Reader;

class PetReadingRepository extends AbstractRepository implements PetReadingRepositoryInterface
{
    protected $model;
    protected $pet;
    protected $user;
    protected $device;


    public function __construct(Reading $model, UserRepositoryInterface $user, DeviceRepositoryInterface $device)
    {
        $this->model = $model;
        $this->user = $user;
        $this->device = $device;
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


    public function readingUpload($input, $user)
    {
        $sUserType = strtolower((new \ReflectionClass($user))->getShortName());
        $sTypeID = $sUserType.'_id';
        $sMethodPet = ($sUserType==='vet') ? 'petsNoAssgined' : 'pets';
        $destinationPath = 'uploads/csv/' . \Crypt::encrypt($user->id);

        if (!\File::exists($destinationPath)) {
            \File::makeDirectory($destinationPath);
        }

        $extension = $input['file']->getClientOriginalExtension();
        $fileName = rand(11111, 99999) . '.' . $extension;
        $input['file']->move($destinationPath, $fileName);
        $csv = Reader::createFromFileObject(new \SplFileObject($destinationPath . '/' . $fileName));

        $topRow = $csv->fetchOne(0);
        $device_current_time_epoch = $topRow[4];

        $csv->setOffset(1);
        $data = $csv->fetch();

        foreach ($data as $lineIndex => $row) {
            $decodedInfo = $this->decoded_microchip_id($row[1]);
            $decodedMicrochipID = $decodedInfo['manufacturer'].'.'.$decodedInfo['device_id'];

            $profile = $this->model
                            ->where('microchip_id', '=', $decodedMicrochipID)
                            ->where('reading_time', '=', new \DateTime("@$row[3]"))
                            ->first();

            $petOwner = $user->$sMethodPet()->checkMicrochip($decodedMicrochipID)->first();
            $pet = Pet::checkMicrochip($decodedMicrochipID)->first();

            if (!$petOwner && $pet) {
                throw new \Exception('The microchip has been already selected', 111);
                return false;
            }

            if (!$petOwner && !$pet) {
                //Saving the pet
                $pet = new pet();
                $pet->microchip_number = $decodedMicrochipID;
                $pet->$sTypeID = $user->id;
                $pet->save();

            } elseif($petOwner) {
                $pet = $petOwner;

            }

            if (empty($profile)) {
                $device = $this->device->setUser($user->id)->findBySerialNumber($decodedInfo['device_id'])->first();
                if (empty($device)){
                    $device = new Device();
                    $device->serial_id = $decodedInfo['device_id'];
                    $device->$sTypeID = $user->id;
                    $device->save();

                }

                $reading = new Reading();
                $reading->microchip_id = $decodedMicrochipID;
                $reading->temperature = $this->reading_temperature($row[2]);
                $reading->pet_id = $pet->id;
                $reading->average = 1;
                $reading->reading_time = $this->reading_timestamp($device_current_time_epoch, $row[3]);
                //Linking to the device table
                $reading->device()->associate($device);
                $reading->save();
                //Adding row related to the readingsVets
                if ($sUserType==='vet') {
                    $reading->vets()->attach($user->id);
                }
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

    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->userRepository->get($user) : $user;

        return $this;
    }


    public function deleteReading($pet_id, $reading_id) {
        if ($this->user) {
            $pet = $this->user->pets()->findOrFail($pet_id);
            $reading = $pet->readings()->findOrFail($reading_id);
            //Deleting Reading
            $reading->delete();
        }

        return true;

    }


    public function updateTimeout($input)
    {
        $this->created_at->addSeconds(30);
        return $this;

    }

    /*
    * Reassigning the readings from the microchip to the new assigned Pet.
    *
    * @param int  $pet_id      Pet ID
    * @param int  $newPetId    New Pet ID
    *
    * @return void
    *
    */
    public function reassignReadings($pet_id, $newPetId)
    {
        Reading::where('pet_id' , $pet_id)->update(['pet_id' => $newPetId]);

    }


    public function addSymptom($input) {
        return $this->get($input['reading_id'])->symptoms()->attach($input['symptom_id']);

    }

    private function decoded_microchip_id($coded_string)
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
        return [
            'manufacturer'  =>  $manufacturer,
            'device_id'    =>   $device_id
        ];

    }

    private function reading_timestamp($device_current_time_epoch, $epoch)
    {
        $epoch =  time()  - ($device_current_time_epoch + $epoch);
        return new \DateTime("@$epoch");

    }

    private function reading_temperature($temperature)
    {
        return ($temperature * 0.112) + 23.3;

    }

}

?>
