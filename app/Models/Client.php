<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    protected $table = 'clients';


    public function client_type()
    {
        return $this->belongsTo('Reflex\Models\ClientType');
    }

    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }

    public function zone()
    {
        return $this->belongsTo('Reflex\Models\Zone');
    }

    public function category()
    {
        return $this->belongsTo('Reflex\Models\Category');
    }

    public function place()
    {
        return $this->belongsTo('Reflex\Models\Place');
    }

    public function hobby()
    {
        return $this->belongsTo('Reflex\Models\Hobby');
    }

    public function specialty_base()
    {
        return $this->belongsTo('Reflex\Models\Specialty','specialty_base_id','id');
    }

    public function specialty_target()
    {
        return $this->belongsTo('Reflex\Models\Specialty','specialty_target_id','id');
    }

    public function university()
    {
        return $this->belongsTo('Reflex\Models\University');
    }

    public function location()
    {
        return $this->belongsTo('Reflex\Models\Location');
    }

    public function parent()
    {
        return $this->belongsTo('Reflex\Models\Client', 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany('Reflex\Models\Client', 'parent_id');
    }

    public function schedules()
    {
        return $this->hasMany('Reflex\Models\Schedule');
    }
}
