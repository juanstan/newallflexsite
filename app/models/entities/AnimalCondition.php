<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class AnimalCondition extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;  
    
    protected $hidden = [
            'created_at',
            'updated_at'
        ];

    protected $fillable = [
        'animal_id',
        'condition_id'     
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'animal_conditions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    public function animal()
    {
        return $this->belongsTo('Entities\Animal', 'animal_id');
    }

    public function condition()
    {
        return $this->belongsTo('Entities\Condition');
    }

}
