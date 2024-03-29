<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model {

    protected $table = 'campaigns';

    protected $fillable = ['company_id', 'code', 'name', 'description', 'start_date', 'close_date', 'finish_date',
        'qty_days', 'active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }


}
