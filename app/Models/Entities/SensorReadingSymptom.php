<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class SensorReadingSymptom extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'reading_id',
        'symptom_id',
    ];
    
    public function sensorReading()
    {
        return $this->belongsTo('\App\Models\Entities\SensorReading', 'reading_id');
    }
    
    public function symptom()
    {
        return $this->belongsTo('\App\Models\Entities\Symptom');
    }
}
