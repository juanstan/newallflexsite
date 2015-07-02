<?php namespace App\Models\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends \Eloquent {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Entities\User');
    }
}