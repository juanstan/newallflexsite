<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'oauth_provider',
        'oauth_uid',
        'password',
        'deleted_at',
        'devices',
        'access',
        'tokens',
        'confirmation_code',
    ];

    protected $fillable = [
        'oauth_provider',
        'oauth_uid',
        'email',
        'first_name',
        'last_name',
        'telephone',
        'image_path',
        'units',
        'weight_units',
        'password',
        'confirmation_code'
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }
    
    public function tokens()
    {
        return $this->hasMany('App\Models\Entities\User\Token');
    }
    
    public function requests()
    {
        return $this->hasMany('App\Models\Entities\Animal\Request');
    }
    
    public function animals()
    {
        return $this->hasMany('App\Models\Entities\Animal');
    }
    
    public function profiles()
    {
        return $this->hasMany('App\Models\Entities\Profile');
    }
    
    public function device()
    {
        return $this->belongsToMany('App\Models\Entities\Device', 'device_users')->withTimestamps();
    }

}
