<?php namespace App\Models\Repositories;

use App\Models\Entities\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
	protected $classname = 'App\Models\Entities\User';

	public function getByEmailForLogin($email_address)
	{
		return User::with('tokens')
			->where('email', '=', $email_address)
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
			'email' => ['required','email','unique:users'],
            'telephone' => [],
            'password'      => ['required','min:6','confirmed'],
            'password_confirmation' => ['required','min:6'],
            'access' => [],
		]);
	}

	public function getFacebookCreateValidator($input)
	{
		return \Validator::make($input,
			[
				'id'    => ['required'],
				'first_name'    => ['required'],
				'last_name'     => ['required'],
				//'email' => ['required','email','unique:users'],
				'code'	=> ['required'],
			]);
	}

	public function getFacebookLoginValidator($input)
	{
		return \Validator::make($input,
			[
				'id'    => ['required'],
				'code'	=> ['required'],
			]);
	}

	public function getTwitterCreateValidator($input)
	{
		return \Validator::make($input,
			[
				'id'    => ['required'],
				'screen_name'     => ['required'],
				'oauth_token'	=> ['required'],
			]);
	}

	public function getTwitterLoginValidator($input)
	{
		return \Validator::make($input,
			[
				'id'    => ['required'],
				'oauth_token'	=> ['required'],
			]);
	}

	public function getLoginValidator($input)
	{
		return \Validator::make($input,
		[
			'email' => ['required','email','exists:users'],
			'password'      => ['required','min:6']
		]);
	}

	public function getUpdateValidator($input, $id = null)
	{
		return \Validator::make($input,
		[
			'email' => ['sometimes','required','email','unique:users,email,'.$id],
            //'image_path'     => ['sometimes','max:20000','mimes:jpg,jpeg,png'],
            'old_password'      => ['min:6'],
            'password'      => ['min:6','confirmed','different:old_password'],
            'password_confirmation' => ['min:6'],
		]);
	}

}

?>
