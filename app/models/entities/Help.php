<?php namespace Entities;

class Help extends \Eloquent {

    protected $fillable = [
        'title',
        'cover',
        'content'
    ];

    protected $table = 'help';

}
