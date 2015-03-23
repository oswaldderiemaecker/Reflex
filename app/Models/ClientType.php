<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model {

	protected $table = 'client_types';

    protected $fillable = ['code','name', 'description','active'];

}
