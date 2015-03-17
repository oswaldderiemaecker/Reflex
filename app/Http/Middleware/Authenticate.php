<?php namespace Reflex\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\Session\Session;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}else{

        //    Session::put('company_id', $this->auth->user()->company_id);
      //      Session::put('company_name', $this->auth->user()->company_id);
         //   Session::put('role_id', $this->auth->user()->role_id);
        //    Session::put('role_name', $this->auth->user()->role->name);
          //  Session::put('business_unit_id', $this->auth->user()->business_unit_id);
         //   Session::put('business_unit_name', $this->auth->user()->business_unit->name);
           // print_r($this->auth->user()->company->name);
          //  die();
        }

		return $next($request);
	}

}
