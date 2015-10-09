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
        'deleted_at'
    ];

    protected $fillable = [
        'pet_id',
        'microchip_id',
        'device_id',
        'temperature',
        'reading_time',
        'average',
        'pet_id'
    ];
    
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function vet()
    {
        return $this->belongsTo(Vet::class, 'pet_id');
    }

    public function vets()
    {
        return $this->belongsToMany(Vet::class, 'vet_readings', 'reading_id', 'vet_id');
    }
    
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
    
    public function sensorReadingSymptoms()
    {
        return $this->hasMany(SensorReadingSymptom::class, 'reading_id');
    }
}
