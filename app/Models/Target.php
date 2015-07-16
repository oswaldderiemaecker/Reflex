<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model {

    protected $table = 'targets';

    protected $fillable = ['company_id', 'campaign_id','assignment_id', 'client_id', 'qty_visits', 'visits_reg',
        'routes_reg', 'synchro', 'active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }

    public function campaign()
    {
        return $this->belongsTo('Reflex\Models\Campaign');
    }

    public function assignment()
    {
        return $this->belongsTo('Reflex\Models\Assignment');
    }

    public function client()
    {
        return $this->belongsTo('Reflex\Models\Client');
    }

}
