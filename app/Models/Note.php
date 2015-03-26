<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model {

    protected $table = 'notes';

    protected $primaryKey = 'uuid';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['uuid', 'note_type_id', 'zone_id','user_id', 'campaign_id', 'target_id',
            'client_id', 'date', 'time', 'title', 'description', 'is_completed', 'is_from_mobile', 'active', 'synchro'];

    /**
     *
     * Functions
     *
     */
    public function note_type()
    {
        return $this->belongsTo('Reflex\Models\NoteType');
    }

    public function zone()
    {
        return $this->belongsTo('Reflex\Models\Zone');
    }

    public function campaign()
    {
        return $this->belongsTo('Reflex\Models\Campaign');
    }

    public function client()
    {
        return $this->belongsTo('Reflex\Models\Client');
    }

    public function target()
    {
        return $this->belongsTo('Reflex\Models\Target');
    }

    public function user()
    {
        return $this->belongsTo('Reflex\User');
    }

}
