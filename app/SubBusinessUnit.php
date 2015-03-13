<?php namespace Reflex;

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
        return $this->belongsTo('Reflex\BusinessUnit');
    }
}