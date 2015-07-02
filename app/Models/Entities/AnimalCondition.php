<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalCondition extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
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
        return $this->belongsTo('App\Models\Entities\Animal', 'animal_id');
    }

    public function condition()
    {
        return $this->belongsTo('App\Models\Entities\Condition');
    }

}
