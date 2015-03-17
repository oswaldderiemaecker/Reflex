<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model {

    protected $table = 'zones';
/*
    protected $fillable = ['company_id','locations.name','regions','business_unit_id',
        'code','name','hidden_name', 'description','qty_doctors','qty_contacts_am','qty_contacts_pm','qty_contacts_vip',
        'qty_available_days','zone_type','vacancy','active'];
*/
    //protected  $fillable = ['*'];

    public function company()
    {
        return $this->belongsTo('Reflex\Company');
    }


    public function business_unit()
    {
        return $this->belongsTo('Reflex\BusinessUnit');
    }


    public function locations()
    {
        //return $this->belongsToMany('Reflex\Location', 'zone_locations', 'zone_id','location_id');
        return $this->belongsToMany('Reflex\Location');
    }

    public function regions()
    {
        return $this->belongsToMany('Reflex\Region');
    }

    public function users()
    {
        return $this->belongsToMany('Reflex\User');
    }
}
