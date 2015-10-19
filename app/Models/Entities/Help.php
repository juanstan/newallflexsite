<?php namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Help extends Model {

    protected $fillable = [
        'title',
        'cover',
        'content'
    ];

    protected $table = 'help';

}
