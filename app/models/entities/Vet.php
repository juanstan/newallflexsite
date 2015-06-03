<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Vet extends \Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'password',
        'deleted_at',
        'devices',
        'access',
        'tokens',
        'confirmation_code',
        'deleted_at'
    ];

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'telephone',
        'fax',
        'address_1',
        'address_2',
        'city',
        'county',
        'zip',
        'units',
        'latitude',
        'longitude',
        'image_path',
        'password',
        'confirmation_code'
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }
    
    public function tokens()
    {
        return $this->hasMany('Entities\Vet\Token');
    }
    
    public function requests()
    {
        return $this->hasMany('Entities\Animal\Request', 'vet_id');
    }
    
    public function requestedAnimals()
    {
        return $this->belongsToMany('Entities\Animal', 'animal_requests')->withTimestamps();
    }

    public function animals()
    {
        return $this->requestedAnimals()->wherePivot('approved', '=', '1');
    }

    public function sensorReadings()
    {
        return $this->belongsToMany('Entities\SensorReading', 'vet_readings', 'vet_id', 'reading_id');
    }
    
    public function device()
    {
        return $this->belongsToMany('Entities\Device', 'device_vets')->withTimestamps();
    }
    
}
