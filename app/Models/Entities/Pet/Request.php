<?php namespace App\Models\Entities\Pet;

use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends \Eloquent {

	use SoftDeletes;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
        ];

    protected $fillable = [
        'vet_id',
        'pet_id',
        'approved',
    ];

	protected $table = 'pet_vet';
    
    public function vet()
    {
        return $this->belongsTo(Vet::class, 'vet_id');
    }
    
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }
    
     public function request()
    {
        return $this->belongsToMany(Pet::class, Vet::class, 'pet_id', 'vet_id');
    }
    
    
 
}    
