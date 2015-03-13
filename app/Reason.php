<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model {

	protected $table = 'reasons';

    protected $fillable = ['code','name', 'description','active'];

}
