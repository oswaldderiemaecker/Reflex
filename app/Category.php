<?php namespace Reflex;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';

    protected $fillable = ['company_id','code','name','qty_visits', 'description','active'];

    public function company()
    {
        return $this->belongsTo('Reflex\Company');
    }

}
