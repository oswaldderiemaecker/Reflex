<?php namespace Reflex;

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
        return $this->belongsTo('Reflex\BusinessUnit');
    }

    public function scopeFreesearch($query, $value)
    {
        return $query->where('name','like','%'.$value.'%')
            ->orWhere('code','like','%'.$value.'%')
            ->orWhereHas('business_unit', function ($q) use ($value) {
                $q->where('name','like','%'.$value.'%')->orWhereHas('company', function ($q) use ($value) {
                    $q->where('name','like','%'.$value.'%');
                });
            });

    }

    public function users()
    {
        return $this->hasMany('Reflex\User', 'sub_business_unit_id','id');
    }
}