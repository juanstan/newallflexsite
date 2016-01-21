<?php namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model {

    protected $fillable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function pets()
    {
        return $this->belongsToMany(Pet::class, 'condition_pet', 'condition_id', 'pet_id')->withTimestamps();
    }

}
