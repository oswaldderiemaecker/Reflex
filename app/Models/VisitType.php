<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class VisitType extends Model {
    protected $table = 'visit_types';

    protected $fillable = ['code','name', 'description','active'];


}
