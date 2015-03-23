<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model {

    protected $table = 'zones';

    protected $fillable = ['company_id',
        'business_unit_id', 'sub_business_unit_id', 'code', 'name', 'hidden_name', 'description',
        'qty_doctors', 'qty_contacts_am', 'qty_contacts_pm', 'qty_contacts_vip',
        'qty_available_days', 'zone_type', 'vacancy', 'active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }

    public function business_unit()
    {
        return $this->belongsTo('Reflex\Models\BusinessUnit');
    }

    public function sub_business_unit()
    {
        return $this->belongsTo('Reflex\Models\SubBusinessUnit');
    }

    public function locations()
    {
        //return $this->belongsToMany('Reflex\Location', 'zone_locations', 'zone_id','location_id');
        return $this->belongsToMany('Reflex\Models\Location');
    }

    public function regions()
    {
        return $this->belongsToMany('Reflex\Models\Region');
    }

    public function users()
    {
        return $this->belongsToMany('Reflex\User');
    }

    public function specialties()
    {
        return $this->belongsToMany('Reflex\Models\Specialty');
    }
}
