<?php namespace App\Models\Repositories;

use App\Models\Entities\Device;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeviceRepository extends AbstractRepository implements DeviceRepositoryInterface
{

	protected $model;
	protected $user;

	public function __construct(Device $model, UserRepositoryInterface $user)
	{
		$this->model = $model;
		$this->user = $user;
	}

	public function getCreateValidator($input)
	{
		return \Validator::make($input,
		[
			'serial_id'    => ['required'],
			'device'     => ['required'],
			'version' => ['required'],
		]);
	}

	public function all()
	{
		if($this->user)
		{
			return $this->user->device()->get();
		}

		return parent::all();
	}


	public function getUpdateValidator($input)
	{
		return \Validator::make($input,
		[
			
		]);
	}
    
    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->user->get($user) : $user;

        return $this;
    }
    
    public function create($input)
    {

        $device = $this->model->create($input);
		$device->user()->associate($this->user);
		$device->save();

		return $device;
    
    }


	public function destroy($device_id) {
		if($this->user)
		{
			return $this->user->device()->findOrFail($device_id)->delete();
		}

	}

}

?>
