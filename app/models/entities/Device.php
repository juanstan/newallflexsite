<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Device extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'created_at',
        'updated_at'
        ];

    protected $fillable = [
        'serial_id',
        'device',
        'name',
        'version',
        'field_1',
        'field_2',
        'field_3',
        'field_4'        
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'devices';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    public function user()
    {
        return $this->belongsToMany('Entities\User', 'device_users')->withTimestamps();
    }
    
    public function vet()
    {
        return $this->belongsToMany('Entities\Vet', 'device_vets')->withTimestamps();
    }
    
    public function reading()
    {
        return $this->hasMany('Entities\Reading', 'device_id');
    }

}
