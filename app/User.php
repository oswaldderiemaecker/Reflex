<?php namespace Reflex;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['role_id', 'company_id',
'business_unit_id', 'sub_business_unit_id', 'supervisor_id',
'code', 'firstname', 'lastname', 'closeup_name', 'email',
'username', 'photo', 'facebook_token', 'google_token'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo('Reflex\Role');
    }

    public function company()
    {
        return $this->belongsTo('Reflex\Company');
    }

    public function business_unit()
    {
        return $this->belongsTo('Reflex\BusinessUnit');
    }

    public function sub_business_unit()
    {
        return $this->belongsTo('Reflex\SubBusinessUnit');
    }

    public function parent()
    {
        return $this->belongsTo('Reflex\User', 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany('Reflex\User', 'parent_id');
    }
}
