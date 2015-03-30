<?php namespace Reflex\Http\Controllers\Frontend;

use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;
use Auth;
use Reflex\Models\BusinessUnit;
use Reflex\Models\Company;
use Reflex\User;
use DB;
class HomeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $id = Auth::user()->id;
        $user = User::find($id);

        $businessUnits = BusinessUnit::with('company','sub_business_units')->where('company_id', '=', $user->company_id)->get();
        $company = Company::find($user->company_id);


        return view('frontend.home', array('user' => $user,'company' => $company, 'businessUnits' => $businessUnits));
	}

    public function map()
    {
        $user = Auth::user();
        $zone = Auth::user()->zones->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        return view('frontend.map', compact('user','zone','campaign'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
