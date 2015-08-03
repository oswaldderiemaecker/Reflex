<?php namespace Reflex\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Reflex\Http\Controllers\Controller;

class AuthController extends Controller {

    protected $redirectPath = 'backend/home';

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
        //print_r;die();

       // if($this->auth->user()->role_id == 8)
        //{
        //    $this->redirectPath = 'frontend/home';
       // }

		$this->middleware('guest', ['except' => 'getLogout']);
	}


    public function redirectPath()
    {
        if ($this->auth->user()->role_id == 8)
        {
            return 'frontend/home';
        }

        return $this->redirectPath;
    }


}
