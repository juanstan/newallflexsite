<?php namespace Repositories;

use Entities\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
	protected $classname = 'Entities\User';

	public function getByEmailForLogin($email)
	{
		return User::with('tokens')
			->where('email_address', '=', $email)
			->firstOrFail();
	}

	public function getUserDetails($id)
	{
		return User::findOrFail($id);
	}

	public function getCreateValidator($input)
	{
		return \Validator::make($input,
		[
			'first_name'    => ['required'],
			'last_name'     => ['required'],
			'email_address' => ['required','email','unique:users'],
            'telephone' => [],
            'password'      => ['required','min:6'],
            'access' => [],
		]);
	}

	public function getLoginValidator($input)
	{
		return \Validator::make($input,
		[
			'email_address' => ['required','email','exists:users'],
			'password'      => ['required','min:6']
		]);
	}

	public function getUpdateValidator($input)
	{
		return \Validator::make($input,
		[
			'email_address' => ['sometimes','required','email','unique:users'],
			'first_name'    => ['sometimes','required'],
			'last_name'     => ['sometimes','required'],
			'password'      => ['sometimes','required','min:6']
		]);
	}
}

?>
