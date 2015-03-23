<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessUnit extends Model {

    protected $table = 'business_units';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','name', 'company_id','description'];


    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }

    public function sub_business_units()
    {
        return $this->hasMany('Reflex\Models\SubBusinessUnit', 'business_unit_id','id');
    }
}
