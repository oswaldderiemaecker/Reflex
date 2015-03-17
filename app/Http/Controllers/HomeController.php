<?php namespace Reflex\Http\Controllers;



use Auth;
use Illuminate\Http\Request;
use Reflex\BusinessUnit;
use Reflex\SubBusinessUnit;
use Reflex\User;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 * @return Response
	 */
	public function index()
	{
        $id = Auth::user()->id;
        $user = User::find($id);

        $businessUnits = BusinessUnit::where('company_id', '=', $user->company_id)->get();
		return view('home', array('user' => $user, 'businessUnits' => $businessUnits));
	}

    /**
     * @param var $business_unit_id
     * @return Response
     */
    public function sub_business_unit(Request $request)
    {
       // print_r($request->all());
      //  die();
        $business_unit_id = $request->get('business_unit_id');
        $businessUnit = BusinessUnit::find($business_unit_id);
        $subBusinessUnits = SubBusinessUnit::where('business_unit_id', '=', $business_unit_id)->get();
        return view('sub_business_unit', array('businessUnit' => $businessUnit, 'subBusinessUnits' => $subBusinessUnits));
    }

}
