<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'oauth_provider',
        'oauth_uid',
        'password',
        'deleted_at',
        'devices',
        'access',
        'tokens'
    ];

    protected $fillable = [
        'oauth_provider',
        'oauth_uid',
        'email_address',
        'first_name',
        'last_name',
        'telephone',
        'password'
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    
    public function tokens()
    {
        return $this->hasMany('Entities\User\Token');
    }
    
    public function requests()
    {
        return $this->hasMany('Entities\Animal\Request');
    }
    
    public function animals()
    {
        return $this->hasMany('Entities\Animal');
    }

}
