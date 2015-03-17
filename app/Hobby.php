<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model {

    protected $table = 'hobbies';

    protected $fillable = ['code','name', 'description','active'];


}
