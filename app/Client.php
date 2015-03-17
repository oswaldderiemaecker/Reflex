<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    protected $table = 'clients';


    public function client_type()
    {
        return $this->belongsTo('Reflex\ClientType');
    }

    public function company()
    {
        return $this->belongsTo('Reflex\Company');
    }

    public function zone()
    {
        return $this->belongsTo('Reflex\Zone');
    }

    public function category()
    {
        return $this->belongsTo('Reflex\Category');
    }

    public function place()
    {
        return $this->belongsTo('Reflex\Place');
    }

    public function hobby()
    {
        return $this->belongsTo('Reflex\Hobby');
    }

    public function specialty_base()
    {
        return $this->belongsTo('Reflex\Specialty','specialty_base_id','id');
    }

    public function specialty_target()
    {
        return $this->belongsTo('Reflex\Specialty','specialty_target_id','id');
    }

    public function university()
    {
        return $this->belongsTo('Reflex\University');
    }

    public function location()
    {
        return $this->belongsTo('Reflex\Location');
    }

    public function parent()
    {
        return $this->belongsTo('Reflex\Client', 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany('Reflex\Client', 'parent_id');
    }
}
