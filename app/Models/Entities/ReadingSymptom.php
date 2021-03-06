<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReadingSymptom extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'reading_id',
        'symptom_id',
    ];
    
    public function reading()
    {
        return $this->belongsTo(Reading::class, 'reading_id');
    }
    
    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
