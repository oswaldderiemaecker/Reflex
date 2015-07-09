<?php namespace Reflex\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function image_client($cmp)
	{
		$cmp = substr('00000' . $cmp, -5);
		$path = public_path() . '/pictures/' . $cmp . '.jpg';

		if (!File::exists($path)) {

			$path = public_path() . '/images/avatar.png';
		}

		return $this->responseFactory->make(File::get($path), 200, array('Content-Type' => File::type($path)));
	}

}
