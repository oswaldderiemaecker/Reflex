<?php
namespace Reflex\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		//
	];

	public function handle($request, Closure $next)
	{
		// Add this:
		if($request->method() == 'POST' || $request->method() == 'PUT' || $request->method() == 'DELETE')
		{
			return $next($request);
		}

		if ($request->method() == 'GET' || $this->tokensMatch($request))
		{
			return $next($request);
		}
		throw new TokenMismatchException;
	}
}