<?php
namespace Reflex\Http\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated
{
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
		if ($this->auth->check())
		{
           // print_r($this->auth->user()->role_id ); die();
            if($this->auth->user()->role_id == 1 or $this->auth->user()->role_id == 2)
            {
                return new RedirectResponse(url('/backend/home'));
            }elseif($this->auth->user()->role_id == 8)
            {
                return new RedirectResponse(url('/frontend/home'));
            }

		}

		return $next($request);
	}

}
