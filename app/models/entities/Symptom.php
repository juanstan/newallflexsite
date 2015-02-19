<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Symptom extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        
        ];

    protected $fillable = [
        'reading_id',
        'symptom_id',
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sensor_reading_symptoms';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    
    public function reading()
    {
        return $this->belongsTo('Entities\Reading', 'reading_id');
    }
}
