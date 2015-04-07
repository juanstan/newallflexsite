<?php namespace Entities\Animal;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Request extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'created_at',
        'updated_at'
        ];

    protected $fillable = [
        'vet_id',
        'user_id',
        'animal_id',
        'approved',
        'request_type',
        'request_reason',
        'response_reason',
        'expiry_type',
        'expiry_days'       
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'animal_requests';

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
        return $this->belongsTo('Entities\Vet', 'vet_id');
    }
    
    public function animal()
    {
        return $this->belongsTo('Entities\Animal', 'animal_id');
    }
    
     public function request()
    {
        return $this->belongsToMany('Entities\Animal', 'Entities\Vet', 'animal_id', 'vet_id');
    }
    
    
 
}    
