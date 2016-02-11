<?php namespace App\Models\Repositories;

use Auth;
use Validator;
use Cache;
use App\Models\Entities\Symptom;

class SymptomRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	protected $model;
	protected $petRepository;
	protected $readingRepository;
	protected $user;


	public function __construct(Symptom $model, PetRepositoryInterface $pet, ReadingRepositoryInterface $reading)
	{
		$this->model = $model;
		$this->petRepository = $pet;
		$this->readingRepository = $reading;
		$this->user = Auth::user()->get();;
	}


	public function all()
	{
		return Cache::remember('symptoms', 10, function()
		{
			return $this->model->all();
		});

	}


	public function getCreateValidator($input)
	{
		return Validator::make($input,
				[
					
				]);
	}


	public function getUpdateValidator($input)
	{
		return Validator::make($input,
				[

				]);
	}


	/*
	 * Get a specific pet for the current user
	 *
	 * @param $pet_id 		int 	Pet ID
	 *
	 * @return /Collection/Pet
	 *
	 */
	public function getPet($pet_id) {
		try {
			$this->petRepository->setUser($this->user);
			return $this->petRepository->get($pet_id);

		} catch(\Exception $e) {
			throw new \Exception('Pet can not be found', 412);

		}

	}

	/*
	 * Get a reading for a specific pet assigned to the current user
	 *
	 * @param $pet_id 		int 	Pet ID
	 * @param $reading_id	int 	Sensor Reading ID
	 *
	 * @return /Collection/SensorReading
	 *
	 */

	public function getAssignedReadingById($input) {
		try {
			return $this->getPet($input['pet_id'])->readings()->findOrFail($input['reading_id']);

		} catch(\Exception $e){
			if ($e->getCode()===412) {
				throw new $e;

			} else {
				throw new \Exception('Sensor not found',414);

			}

		}

	}


}

?>