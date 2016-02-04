<?php namespace App\Models\Repositories;

use App\Models\Entities\Vet;
use Carbon\Carbon;
use DB;

class VetRepository extends AbstractRepository implements VetRepositoryInterface
{
	protected $model;


	public function __construct(Vet $model)
	{
		$this->model = $model;
	}

	public function getByEmailForLogin($email)
	{
		return $this->model->with('tokens')
			->where('email', '=', $email)
			->firstOrFail();

	}

	public function getVetDetails($id)
	{
		return $this->model->findOrFail($id);

	}

	public function getCreateValidator($input)
	{
		return \Validator::make($input,
		[
			'email' 				=> ['required','email','unique:vets,email,NULL,id,deleted_at,NULL'],
            'password'      		=> ['required','min:6','confirmed'],
            'password_confirmation' => ['required','min:6']
		]);
	}

	public function getLoginValidator($input)
	{
		return \Validator::make($input,
		[
			'email' => ['required','email','exists:vets'],
			'password'      => ['required','min:6']
		]);
	}

	public function getUpdateValidator($input, $id = null)
	{
		return \Validator::make($input,
		[
            'email' 					=> ['sometimes','required','email','unique:vets,email,'.$id],
			'first_name'    			=> ['sometimes','required'],
			'last_name'     			=> ['sometimes','required'],
			'zip'						=> ['sometimes','required'],
			'address_1'					=> ['sometimes','required'],
			'old_password'  			=> ['min:6'],
            'password'      			=> ['min:6','confirmed','different:old_password'],
            'password_confirmation' 	=> ['min:6'],
		]);
	}


	public function getUnassignedPets($vet) {
		return $vet->petsNoAssgined()->get();

	}


	public function getVetsCloserTo($location, $distance=10) {

		return DB::table('vets')->select(
			DB::raw("company_name,
			( 3959 * acos( cos( radians(latitude) ) * cos( radians( ? ) )
			* cos( radians( ? ) - radians(longitude)) + sin( radians(latitude) )
			* sin( radians( ? ) ) )) AS distance"
			)
		)
		->orderBy("distance")
		->having("distance", "<", (int)$distance)
		->take(20)
		->addBinding(
			[
				(float)$location['lat'],
				(float)$location['lng'],
				(float)$location['lat']
			]
		)->get();

	}


}

?>
