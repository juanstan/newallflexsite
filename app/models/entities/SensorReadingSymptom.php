<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SensorReadingSymptom extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        
        ];

    protected $fillable = [
        'reading_id',
        'symptom_id',
    ];
    
    public function sensorReading()
    {
        return $this->belongsTo('Entities\SensorReading', 'reading_id');
    }
    
    public function symptom()
    {
        return $this->belongsTo('Entities\Symptom');
    }
}
