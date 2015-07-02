<?php namespace App\Models\Entities\Animal;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

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
        return $this->belongsTo('App\Models\Entities\User', 'user_id');
    }
    
    public function vet()
    {
        return $this->belongsTo('App\Models\Entities\Vet', 'vet_id');
    }
    
    public function animal()
    {
        return $this->belongsTo('App\Models\Entities\Animal', 'animal_id');
    }
    
     public function request()
    {
        return $this->belongsToMany('App\Models\Entities\Animal', 'App\Models\Entities\Vet', 'animal_id', 'vet_id');
    }
    
    
 
}    
