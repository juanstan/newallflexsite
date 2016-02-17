<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at', 'reading_time'];

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'pet_id',
        'microchip_id',
        'device_id',
        'temperature',
        'reading_time',
        'average'
    ];
    
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function vet()
    {
        return $this->belongsTo(Vet::class, 'vet_id');
    }
    
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'reading_symptom', 'reading_id', 'symptom_id')->withTimestamps();
    }

}
