<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Vet extends \Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;
    
    protected $hidden = [
        'password',
        'deleted_at',
        'devices',
        'access',
        'tokens'
    ];

    protected $fillable = [
        'company_name',
        'contact_name',
        'email_address',
        'telephone',
        'address_1',
        'address_2',
        'city',
        'state',
        'county',
        'zip',
        'latitude',
        'longitude',
        'image_path',
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
    protected $table = 'vets';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
    public function tokens()
    {
        return $this->hasMany('Entities\Vet\Token');
    }
    
    public function requests()
    {
        return $this->hasMany('Entities\Animal\Request', 'vet_id');
    }
    
    public function animals()
    {
        return $this->hasManyThrough('Entities\Animal', 'Entities\Animal\Request', 'vet_id', 'id');
    }
    
}
