<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Device extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
    
    protected $hidden = [
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
        'field_4',
        'pivot'
    ];
    
    public function user()
    {
        return $this->belongsToMany('App\Models\Entities\User', 'device_users')->withTimestamps();
    }
    
    public function vet()
    {
        return $this->belongsToMany('App\Models\Entities\Vet', 'device_vets')->withTimestamps();
    }
    
    public function sensorReading()
    {
        return $this->hasMany('App\Models\Entities\SensorReading', 'device_id');
    }

}
