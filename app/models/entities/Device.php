<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Device extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'serial_id',
        'device',
        'user_id',
        'name',
        'version',
        'field_1',
        'field_2',
        'field_3',
        'field_4'        
    ];
    
    public function user()
    {
        return $this->belongsToMany('Entities\User', 'device_users')->withTimestamps();
    }
    
    public function vet()
    {
        return $this->belongsToMany('Entities\Vet', 'device_vets')->withTimestamps();
    }
    
    public function sensorReading()
    {
        return $this->hasMany('Entities\SensorReading', 'device_id');
    }

}
