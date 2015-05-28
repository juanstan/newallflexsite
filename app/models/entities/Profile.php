<?php namespace Entities;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Profile extends \Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('Entities\User');
    }
}