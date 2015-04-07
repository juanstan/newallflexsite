<?php namespace Repositories;

use Entities\Device;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeviceRepository extends AbstractRepository implements DeviceRepositoryInterface
{
	protected $classname = 'Entities\Device';

	public function getCreateValidator($input)
	{
		return \Validator::make($input,
		[
			'serial_id'    => ['required'],
			'device'     => ['required'],
			'version' => ['required'],
		]);
	}

	public function getUpdateValidator($input)
	{
		return \Validator::make($input,
		[
			
		]);
	}
    
    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }
    
    public function create($input)
    {
        
        
        $device = parent::create($input);
        if($device->user->find($this->user) == null)
        {
            $device->user()->attach($this->user);
        }
        return $device;
    
    
    } 
}

?>
