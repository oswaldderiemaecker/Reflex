<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Target extends Model {

    protected $table = 'targets';

    protected $fillable = ['company_id', 'campaign_id', 'zone_id', 'user_id', 'client_id', 'qty_visits', 'visits_reg',
        'routes_reg', 'synchro', 'active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Company');
    }

    public function campaign()
    {
        return $this->belongsTo('Reflex\Campaign');
    }

    public function zone()
    {
        return $this->belongsTo('Reflex\Zone');
    }

    public function user()
    {
        return $this->belongsTo('Reflex\User');
    }

    public function client()
    {
        return $this->belongsTo('Reflex\Client');
    }

}
