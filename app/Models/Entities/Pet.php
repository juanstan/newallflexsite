<?php namespace App\Models\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'microchip_number',
        'breed_id',
        'breed_wildcard',
        'date_of_birth',
        'weight',
        'gender',
        'photo_id',
        'user_id'        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function vet()
    {
        return $this->belongsToMany(Vet::class, 'pet_vet', 'pet_id','vet_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function readings()
    {
        return $this->hasMany(Reading::class, 'pet_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function conditions()
    {
        return $this->belongsToMany(Condition::class, 'condition_pet', 'pet_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'pet_photos')->withTimestamps();
    }

    /*
     * querying only the pets with a microchip already set
     *
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent
     *
     */
    public function scopeSetMicrochip($query){
        return $query->whereNotNull('microchip_number');

    }



    public function scopeCheckMicrochip($query, $microchip_number){
        return $query->where('microchip_number', '=', $microchip_number);

    }

}