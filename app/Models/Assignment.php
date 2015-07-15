<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{

    protected $table = 'assignments';

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['id', 'user_id',
        'zone_id', 'campaign_id', 'description', 'active'];

    public function user()
    {
        return $this->belongsTo('Reflex\User');
    }

    public function zone()
    {
        return $this->belongsTo('Reflex\Models\Zone');
    }

    public function campaign()
    {
        return $this->belongsTo('Reflex\Models\Campaign');
    }


}
