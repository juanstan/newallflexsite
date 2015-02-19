<?php namespace Repositories;

use Entities\Vet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VetRepository extends AbstractRepository implements VetRepositoryInterface
{
	protected $classname = 'Entities\Vet';

	public function getByEmailForLogin($email)
	{
		return Vet::with('tokens')
			->where('email_address', '=', $email)
			->firstOrFail();
	}

	public function getVetDetails($id)
	{
		return Vet::findOrFail($id);
	}

	public function getCreateValidator($input)
	{
		return \Validator::make($input,
		[
			'company_name'    => ['required'],
			'contact_name'     => ['required'],
			'email_address' => ['required','email','unique:vets'],
            'password'      => ['required','min:6'],
		]);
	}

	public function getLoginValidator($input)
	{
		return \Validator::make($input,
		[
			'email_address' => ['required','email','exists:vets'],
			'password'      => ['required','min:6']
		]);
	}

	public function getUpdateValidator($input)
	{
		return \Validator::make($input,
		[
			'email_address' => ['sometimes','required','email','unique:vets'],
			'first_name'    => ['sometimes','required'],
			'last_name'     => ['sometimes','required'],
			'password'      => ['sometimes','required','min:6']
		]);
	}
}

?>
