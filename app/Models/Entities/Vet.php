<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vet extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'password',
        'deleted_at',
        'devices',
        'access',
        'tokens',
        'confirmation_code',
    ];

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'telephone',
        'fax',
        'address_1',
        'address_2',
        'city',
        'county',
        'zip',
        'units',
        'latitude',
        'longitude',
        'image_path',
        'password',
        'confirmation_code'
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }
    
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
    
    public function requests()
    {
        return $this->hasMany(Request::class, 'vet_id');
    }
    
    public function requestedPet()
    {
        return $this->belongsToMany(Pet::class, 'pet_requests')->withTimestamps();
    }

    public function pets()
    {
        return $this->requestedPets()->wherePivot('approved', '=', '1');
    }

    public function sensorReadings()
    {
        return $this->belongsToMany(SensorReading::class, 'vet_readings', 'vet_id', 'reading_id');
    }
    
    public function device()
    {
        return $this->belongsToMany(Device::class, 'device_vets')->withTimestamps();
    }
    
}
