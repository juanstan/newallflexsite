<?php namespace App\Models\Entities\Animal;

use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends \Eloquent {

	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
        ];

    protected $fillable = [
        'vet_id',
        'user_id',
        'animal_id',
        'approved',
    ];

	protected $table = 'animal_requests';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function vet()
    {
        return $this->belongsTo(Vet::class, 'vet_id');
    }
    
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
    
     public function request()
    {
        return $this->belongsToMany(Animal::class, Vet::class, 'animal_id', 'vet_id');
    }
    
    
 
}    
