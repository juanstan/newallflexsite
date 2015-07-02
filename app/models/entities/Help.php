<?php namespace App\Models\Entities;

class Help extends \Eloquent {

    protected $fillable = [
        'title',
        'cover',
        'content'
    ];

    protected $table = 'help';

}
