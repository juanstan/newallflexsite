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
			'email_address'    => ['required','unique:vets'],
            'password'      => ['required','min:6','confirmed'],
            'password_confirmation' => ['required','min:6']
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

	public function getUpdateValidator($input, $id = null)
	{
		return \Validator::make($input,
		[
            'email_address' => ['sometimes','required','email','unique:vets,email_address,'.$id],
			'first_name'    => ['sometimes','required'],
			'last_name'     => ['sometimes','required'],
            'old_password'      => ['min:6'],
            'password'      => ['min:6','confirmed','different:old_password'],
            'password_confirmation' => ['min:6'],
		]);
	}
}

?>
