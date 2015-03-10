<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model {

    protected $table = 'companies';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','name', 'country_id','description'];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }



}
