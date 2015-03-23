<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model {

    protected $table = 'specialties';

    protected $fillable = ['code','name', 'description'];

    public function zones()
    {
        return $this->belongsToMany('Reflex\Models\Zone');
    }

    public function sub_business_units()
    {
        return $this->belongsToMany('Reflex\Models\SubBussinessUnit','specialty_sub_business_unit','specialty_id','sub_business_unit');
    }

}
