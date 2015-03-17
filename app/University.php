<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class University extends Model {

    protected $table = 'universities';

    protected $fillable = ['country_id','code','name', 'description','active'];


}
