<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Reading extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'expires_at'
        ];

    protected $fillable = [
        'animal_id',
        'temperature',
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sensor_readings';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    public function animal()
    {
        return $this->belongsTo('Entities\Animal', 'animal_id');
    }
    
    public function symptom()
    {
        return $this->hasMany('Entities\Symptom', 'reading_id');
    }
}
