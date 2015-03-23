<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model{

	protected $table = 'regions';

    protected $fillable = ['country_id','code','name', 'description'];

    public function country()
    {
      return $this->belongsTo('Reflex\Models\Country');
    }

    public function zones()
    {
        return $this->belongsToMany('Reflex\Models\Zone');
    }
}
