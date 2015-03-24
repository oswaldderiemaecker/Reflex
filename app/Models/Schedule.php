<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {

	protected $table = 'schedules';

    protected $primaryKey = 'uuid';

    protected $dates = ['deleted_at'];

    protected $fillable = ['uuid', 'zone_id', 'client_id', 'day', 'start_time', 'finish_time', 'active'];

    public function zone()
    {
        return $this->belongsTo('Reflex\Models\Zone');
    }

    public function client()
    {
        return $this->belongsTo('Reflex\Models\Client');
    }

}
