<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PetCondition extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'pet_id',
        'condition_id'     
    ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'conditions_pet';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

}
