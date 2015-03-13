<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {

	protected $table = 'regions';

    protected $fillable = ['country_id','region_id', 'business_unit_id',
        'code','name', 'description'];

    public function country()
    {
      return $this->belongsTo('Reflex\Country');
    }

}
