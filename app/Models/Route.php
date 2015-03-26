<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model {

    use SoftDeletes;

    protected $table = 'routes';

    protected $primaryKey = 'uuid';

    protected $fillable = ['uuid', 'user_id', 'zone_id', 'campaign_id', 'target_id','client_id',
                           'start', 'end', 'description', 'point_of_contact', 'is_from_mobile', 'active', 'synchro'];

    protected $dates = ['deleted_at'];

    public function zone()
    {
        return $this->belongsTo('Reflex\Models\Zone');
    }

    public function campaign()
    {
        return $this->belongsTo('Reflex\Models\Campaign');
    }

    public function target()
    {
        return $this->belongsTo('Reflex\Models\Target');
    }

    public function client()
    {
        return $this->belongsTo('Reflex\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('Reflex\User');
    }

    public function toArray()
    {
        $this->load('zone', 'client','target');
        return parent::toArray();
    }
}
