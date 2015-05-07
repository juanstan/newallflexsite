<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class SensorReadingsSymptom extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        
        ];

    protected $fillable = [
        'reading_id',
        'symptom_id',
    ];
    
    public function reading()
    {
        return $this->belongsTo('Entities\SensorReading', 'reading_id');
    }
    
    public function symptom()
    {
        return $this->belongsTo('Entities\SensorReadingSymptom', 'symptom_id');
    }
}
