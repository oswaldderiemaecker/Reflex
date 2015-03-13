<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model {

    protected $table = 'zones';

    protected $fillable = ['company_id','region_id', 'business_unit_id',
        'code','name','hidden_name', 'description','qty_doctors','qty_contacts_am','qty_contacts_pm','qty_contacts_vip',
        'qty_available_days','zone_type','vacancy','active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Company');
    }

    public function region()
    {
        return $this->belongsTo('Reflex\Region');
    }

    public function business_unit()
    {
        return $this->belongsTo('Reflex\BusinessUnit');
    }
}
