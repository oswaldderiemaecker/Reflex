<?php namespace Reflex;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;


	protected $table = 'users';

	protected $fillable = ['role_id', 'company_id', 'business_unit_id', 'sub_business_unit_id', 'supervisor_id',
        'code', 'firstname', 'lastname', 'closeup_name', 'email', 'username','password', 'photo', 'facebook_token',
        'google_token'];


	//protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo('Reflex\Models\Role');
    }

    public function company()
    {
        return $this->belongsTo('Reflex\Models\Company');
    }

    public function business_unit()
    {
        return $this->belongsTo('Reflex\Models\BusinessUnit');
    }

    public function sub_business_unit()
    {
        return $this->belongsTo('Reflex\Models\SubBusinessUnit');
    }

    public function parent()
    {
        return $this->belongsTo('Reflex\User', 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany('Reflex\User', 'parent_id');
    }

    public function zones()
    {
        return $this->belongsToMany('Reflex\Models\Zone');
    }
}
