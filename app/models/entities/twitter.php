<?php namespace Entities;

class Twitter extends \Eloquent {

    public function user()
    {
        return $this->belongsTo('Entities\User');
    }
}