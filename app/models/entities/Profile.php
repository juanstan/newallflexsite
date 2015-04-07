<?php namespace Entities;

class Profile extends \Eloquent {

    public function user()
    {
        return $this->belongsTo('Entities\User');
    }
}