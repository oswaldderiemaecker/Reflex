<?php namespace Reflex;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract
{

    use Authenticatable, CanResetPassword, Billable;


	protected $table = 'users';

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	protected $fillable = ['role_id', 'company_id', 'business_unit_id', 'sub_business_unit_id', 'supervisor_id',
        'code', 'firstname', 'lastname', 'closeup_name', 'email', 'username', 'password', 'photo', 'imei', 'facebook_token',
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

    public function assignments()
    {
        return $this->hasMany('Reflex\Models\Assignment', 'user_id', 'id');
    }
}
