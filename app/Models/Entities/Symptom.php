<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Symptom extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $fillable = [
        'name',
    ];


    public function reading()
    {
        return $this->belongsToMany(Reading::class, 'reading_symptom', 'symptom_id', 'reading_id')->withTimestamps();

    }


}
