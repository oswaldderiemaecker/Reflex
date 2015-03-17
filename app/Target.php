<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Target extends Model {

    protected $table = 'targets';

    protected $fillable = ['company_id', 'campaign_id', 'zone_id', 'user_id', 'client_id', 'qty_visits', 'visits_reg',
        'routes_reg', 'synchro', 'active'];

}
