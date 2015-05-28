<?php namespace Entities\Animal;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Request extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'animal_request_id';

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
        ];

    protected $fillable = [
        'vet_id',
        'user_id',
        'animal_id',
        'approved',
    ];

	protected $table = 'animal_requests';
    
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
