<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Animal extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'created_at',
        'updated_at'
        ];

    protected $fillable = [
        'name',
        'microchip_number',
        'breed_id',
        'breed_wildcard',
        'date_of_birth',
        'weight',
        'gender',
        'image_path',
        'user_id'        
    ];

    
    public function user()
    {
        return $this->belongsTo('Entities\User', 'user_id');
    }
    
    public function vet()
    {
        return $this->belongsToMany('Entities\Vet', 'animal_requests');
    }
    
    public function sensorReadings()
    {
        return $this->hasMany('Entities\SensorReading', 'animal_id');
    }

    public function breed()
    {
        return $this->belongsTo('Entities\Breed', 'breed_id');
    }
    
    public function animalConditions()
    {
        return $this->hasMany('Entities\AnimalCondition', 'animal_id');
    }
}
