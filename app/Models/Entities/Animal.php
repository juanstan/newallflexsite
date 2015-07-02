<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
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
        return $this->belongsTo('App\Models\Entities\User', 'user_id');
    }
    
    public function vet()
    {
        return $this->belongsToMany('App\Models\Entities\Vet', 'animal_requests');
    }
    
    public function sensorReadings()
    {
        return $this->hasMany('App\Models\Entities\SensorReading', 'animal_id');
    }

    public function breed()
    {
        return $this->belongsTo('App\Models\Entities\Breed', 'breed_id');
    }
    
    public function animalConditions()
    {
        return $this->hasMany('App\Models\Entities\AnimalCondition', 'animal_id');
    }
}
