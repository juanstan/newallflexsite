<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SensorReading extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'expires_at'
        ];

    protected $fillable = [
        'animal_id',
        'temperature',
        'reading_time'
    ];
    
    public function animal()
    {
        return $this->belongsTo('Entities\Animal', 'animal_id');
    }

    public function vet()
    {
        return $this->belongsTo('Entities\vet', 'animal_id');
    }

    public function vets()
    {
        return $this->belongsToMany('Entities\Vet', 'vet_readings', 'reading_id', 'vet_id');
    }
    
    public function device()
    {
        return $this->belongsTo('Entities\Device', 'device_id');
    }
    
    public function sensorReadingSymptoms()
    {
        return $this->hasMany('Entities\SensorReadingSymptom', 'reading_id');
    }
}
