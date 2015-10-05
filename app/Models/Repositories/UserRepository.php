<?php namespace App\Models\Repositories;

use App\Models\Entities\User;
use App\Models\Entities\Animal;
use App\Models\Entities\Animal\Request;
use App\Models\Entities\SensorReading;
use App\Models\Entities\SensorReadingSymptom;
use Validator;
use Hash;

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
		return Validator::make($input,
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

	/**
	 * @param $userData
	 * @param $provider
	 * @return User|\Illuminate\Database\Eloquent\Model|null
	 */
	public function findByProviderOrCreate($userData, $provider)
	{
		$user = $this->query()->withTrashed()->where('provider_id', '=', $userData->id)->first();

		if ($user != NULL && $user->trashed())
		{
			$user->restore();
		}

		if($user == NULL)
		{
			switch($provider) {
				case 'facebook':
					$user = [
							'first_name' => $userData->user['first_name'],
							'last_name' => $userData->user['last_name'],
							'email' => $userData->email,
							'provider' => $provider,
							'provider_id' => $userData->id,
							'units' => 0,
        					'weight_units' => 0,
					];
					break;
				case 'twitter':
					$name = explode(" ", $userData->name);
					$user = [
							'first_name' => $name[0],
							'last_name' => end($name),
							'email' => $userData->email,
							'provider' => $provider,
							'provider_id' => $userData->id,
							'units' => 0,
							'weight_units' => 0,
					];
					break;
			}

			$user = $this->create($user);
		}
		$this->checkIfProviderNeedsUpdating($userData, $user);
		return $user;
	}

	/**
	 * @param object $userData
	 * @param User $user
	 */
	public function checkIfProviderNeedsUpdating($userData, $user)
	{
		switch($user->provider) {
			case 'facebook':
				$socialData = [
						'email' => $userData->email,
						'first_name' => $userData->user['first_name'],
						'last_name' => $userData->user['last_name'],
				];
				break;
			case 'twitter':
				$name = explode(' ', $userData->name);
				$socialData = [
						'email' => $userData->email,
						'first_name' => array_shift($name),
						'last_name' => implode(' ', $name),
				];
				break;
		}

		$dbData = [
				'email' => $user->email,
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
		];

		if (!empty(array_diff($socialData, $dbData)))
		{
			$this->update($user->id, $socialData);
		}
	}

	public function getLoginValidator($input)
	{
		return Validator::make($input,
		[
			'email' => ['required','email','exists:users'],
			'password'      => ['required','min:6']
		]);
	}

	public function getUpdateValidator($input, $id = null)
	{
		return Validator::make($input,
		[
			'email' => ['sometimes','required','email','unique:users,email,'.$id],
            'old_password'      => ['min:6'],
            'password'      => ['min:6','confirmed','different:old_password'],
            'password_confirmation' => ['min:6'],
		]);
	}

	public function getPasswordCheckValidator($password, $userPassword)
	{
		return Hash::check($password, $userPassword);
	}

	public function delete($id)
	{
		Request::where('user_id', '=', $id)->delete();
		$animals = Animal::where('user_id', '=', $id)->get();
		foreach ($animals as $animal) {
			$animal_id = $animal->id;
			$sensor_readings = SensorReading::where('animal_id', '=', $animal_id)->get();
			foreach ($sensor_readings as $sensor_reading) {
				$sensor_reading_id = $sensor_reading->id;
				SensorReadingSymptom::where('reading_id', '=', $sensor_reading_id)->delete();
			}
			SensorReading::where('animal_id', '=', $animal_id)->delete();
		}
		Animal::where('user_id', '=', $id)->delete();
		$object = $this->get($id);
		$object->delete();
	}

}

?>