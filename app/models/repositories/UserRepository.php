<?php namespace Repositories;

use Entities\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
	protected $classname = 'Entities\User';

	public function getByEmailForLogin($email_address)
	{
		return User::with('tokens')
			->where('email_address', '=', $email_address)
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
			'first_name'    => [],
			'last_name'     => [],
			'email_address' => ['required','email','unique:users'],
            'telephone' => [],
            'password'      => ['required','min:6','confirmed'],
            'password_confirmation' => ['required','min:6'],
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

	public function getUpdateValidator($input, $id = null)
	{
		return \Validator::make($input,
		[
			'email_address' => ['sometimes','required','email','unique:users,email_address,'.$id],
            'image_path'     => ['sometimes','max:20000','mimes:jpeg,png'],
            'old_password'      => ['min:6'],
            'password'      => ['min:6','confirmed','different:old_password'],
            'password_confirmation' => ['min:6'],
		]);
	}

}

?>
