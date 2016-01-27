<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
    
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'location',
        'uploading_user_id',
    ];

    static public function boot()
    {
        parent::boot();
    }
    
    public function uploadingUser()
    {
        return $this->belongsTo(User::class, 'uploading_user_id');
    }

}
