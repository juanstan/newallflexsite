<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Entities\Vet\Token;

class Vet extends Model implements AuthenticatableContract, CanResetPasswordContract {

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
        'photo_id',
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

    public function pets()
    {
        return $this->belongsToMany(Pet::class, 'pet_vet')->withTimestamps();
    }

    public function approvedPets()
    {
        return $this->pets()->wherePivot('approved', '=', '1');
    }

    public function readings()
    {
        return $this->hasMany(Reading::class, 'vet_id');
    }
    
    public function device()
    {
        return $this->hasMany(Device::class, 'vet_id');
    }


    public function petsNoAssgined(){
        return $this->hasMany(Pet::class, 'vet_id');

    }

    public function scopeSetMicrochip($query){
        return $query->whereNotNull('microchip_number');

    }

    public function scopeNoSetName($query){
        return $query->whereNull('name');

    }
    
}
