<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class Device extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

    protected $fillable = [
        'serial_id',
        'device',
        'user_id',
        'name',
        'version',
        'field_1',
        'field_2',
        'field_3',
        'field_4',
        'pivot'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function vet()
    {
        return $this->belongsTo(Vet::class, 'vet_id');
    }
    
    public function sensorReading()
    {
        return $this->hasMany(SensorReading::class, 'device_id');
    }

}
