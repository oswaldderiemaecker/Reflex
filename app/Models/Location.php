<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $table ='locations';

    protected $fillable = ['country_id','region_id','code','name','department','province','district','description'];

    public function country()
    {
        return $this->belongsTo('Reflex\Models\Country');
    }
    public function region()
    {
        return $this->belongsTo('Reflex\Models\Region');
    }

    public function zones()
    {
        return $this->belongsToMany('Reflex\Models\Zone');
    }

}
