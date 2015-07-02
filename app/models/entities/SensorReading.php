<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class SensorReading extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'expires_at',
        'deleted_at'
    ];

    protected $fillable = [
        'animal_id',
        'microchip_id',
        'device_id',
        'temperature',
        'reading_time',
        'average',
        'animal_id'
    ];
    
    public function animal()
    {
        return $this->belongsTo('App\Models\Entities\Animal', 'animal_id');
    }

    public function vet()
    {
        return $this->belongsTo('App\Models\Entities\vet', 'animal_id');
    }

    public function vets()
    {
        return $this->belongsToMany('App\Models\Entities\Vet', 'vet_readings', 'reading_id', 'vet_id');
    }
    
    public function device()
    {
        return $this->belongsTo('App\Models\Entities\Device', 'device_id');
    }
    
    public function sensorReadingSymptoms()
    {
        return $this->hasMany('App\Models\Entities\SensorReadingSymptom', 'reading_id');
    }
}
