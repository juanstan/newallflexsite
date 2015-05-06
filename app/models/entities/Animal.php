<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Animal extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'created_at',
        'updated_at'
        ];

    protected $fillable = [
        'name',
        'microchip_number',
        'breed',
        'date_of_birth',
        'weight',
        'size',
        'gender',
        'image_path',
        'user_id'        
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'animals';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    public function user()
    {
        return $this->belongsTo('Entities\User', 'user_id');
    }
    
    public function vet()
    {
        return $this->belongsToMany('Entities\Vet', 'animal_requests');
    }
    
    public function readings()
    {
        return $this->hasMany('Entities\Reading', 'animal_id');
    }

    public function breeds()
    {
        return $this->belongsTo('Entities\Breed', 'breed_id');
    }
    
    public function conditions()
    {
        return $this->hasMany('Entities\Condition', 'animal_id');
    }
}
