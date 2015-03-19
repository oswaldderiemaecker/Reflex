<?php namespace Reflex\Http\Controllers;



use Auth;
use Illuminate\Http\Request;
use Reflex\BusinessUnit;
use Reflex\Company;
use Reflex\Role;
use Reflex\SubBusinessUnit;
use Reflex\User;
use Zofe\Rapyd\Facades\DataForm;

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

        $businessUnits = BusinessUnit::with('company','sub_business_units')->where('company_id', '=', $user->company_id)->get();
        $company = Company::find($user->company_id);
		return view('home', array('user' => $user,'company' => $company, 'businessUnits' => $businessUnits));
	}

    /**
     * @param Request $request
     * @return Response
     */
    public function sub_business_unit(Request $request)
    {
        $business_unit_id = $request->get('business_unit_id');
        $businessUnit = BusinessUnit::find($business_unit_id);
        $subBusinessUnits = SubBusinessUnit::with('users')->where('business_unit_id', '=', $business_unit_id)->get();
        return view('sub_business_unit', array('businessUnit' => $businessUnit, 'subBusinessUnits' => $subBusinessUnits));
    }



}
