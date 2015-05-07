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
        'tokens',
        'confirmation_code'
    ];

    protected $fillable = [
        'oauth_provider',
        'oauth_uid',
        'email_address',
        'first_name',
        'last_name',
        'telephone',
        'image_path',
        'units',
        'password',
        'confirmation_code'
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }
    
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
    
    public function profiles()
    {
        return $this->hasMany('Entities\Profile');
    }
    
    public function device()
    {
        return $this->belongsToMany('Entities\Devive', 'device_users')->withTimestamps();
    }

}
