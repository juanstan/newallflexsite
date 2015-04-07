<?php namespace Entities;

class Help extends \Eloquent {

    protected $hidden = [

    ];

    protected $fillable = [
        'title',
        'cover',
        'content'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'help';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

}
