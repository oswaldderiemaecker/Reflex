<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model {

    protected $table = 'visits';

    protected $primaryKey = 'uuid';

    use SoftDeletes;

    protected $dates = ['created_at','updated_at','deleted_at','start','end'];

    protected $fillable = ['uuid', 'route_uuid', 'visit_type_id','assignment_id',
        'visit_status_id', 'reason_id', 'zone_id','user_id', 'campaign_id', 'target_id',
        'specialty_id', 'client_id', 'start', 'end', 'supervisor',
        'description', 'cmp', 'firstname', 'lastname',
        'is_supervised', 'is_from_mobile', 'active', 'synchro', 'longitude', 'latitude'];

    public function visit_type()
    {
        return $this->belongsTo('Reflex\Models\VisitType');
    }

    public function visit_status()
    {
        return $this->belongsTo('Reflex\Models\VisitStatus');
    }

    public function reason()
    {
        return $this->belongsTo('Reflex\Models\Reason');
    }

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

    public function specialty()
    {
        return $this->belongsTo('Reflex\Models\Specialty');
    }

    public function client()
    {
        return $this->belongsTo('Reflex\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('Reflex\User');
    }
}
