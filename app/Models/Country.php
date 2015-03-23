<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'countries';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','name', 'currency', 'language','description'];

    public function companies()
    {
        return $this->hasMany('Reflex\Models\Company','country_id');
    }

}
