<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model {

    protected $table = 'specialties';

    protected $fillable = ['code','name', 'description','active'];


}
