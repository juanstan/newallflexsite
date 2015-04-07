<?php namespace Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class SymptomNames extends \Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;
    
    protected $hidden = [
        
        ];

    protected $fillable = [
        'name',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'symptoms';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
    
    public function symptom()
    {
        return $this->hasMany('Entities\Symptom', 'symptom_id');
    }
    
}
