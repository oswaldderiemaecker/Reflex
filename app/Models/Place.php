<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model {

    protected $table = 'places';

    protected $fillable = ['company_id','code','name', 'description','active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }

}
