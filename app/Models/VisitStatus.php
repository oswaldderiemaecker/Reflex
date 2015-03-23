<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class VisitStatus extends Model {
    protected $table = 'visit_status';

    protected $fillable = ['code','name', 'description','active'];


}
