<?php namespace Reflex\Http\Controllers\Frontend;

use Auth;
use DB;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Visit;

class NoteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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

    public function main()
    {
		$assignment = Auth::user()->assignments->first();
		$zone = DB::table('zones')->where('id', '=', $assignment->zone_id)->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        $visits = Visit::with('target','user','client','client.location','client.category','client.place');
        $visits->where('visit_status_id','=', '2');
        $visits->where('campaign_id','=', $campaign->id);
        $visits->whereHas('target', function($q) use($zone){
            $q->where('company_id','=',$zone->company_id);
        });
        $visits->orderby('start','DESC');

        $datos = $visits->get();


        return view('frontend.visit.note', compact('datos'));
    }

}
