<?php namespace Reflex\Models;

use GuzzleHttp\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubBusinessUnit extends Model {

    protected $table = 'sub_business_units';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','name', 'business_unit_id','description'];


    public function business_unit()
    {
        return $this->belongsTo('Reflex\Models\BusinessUnit');
    }

    public function users()
    {
        return $this->hasMany('Reflex\User', 'sub_business_unit_id','id');
    }

    public function specialties()
    {
        return $this->belongsToMany('Reflex\Models\Specialty');

    }
}