<?php namespace Reflex\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Reflex\Models\Schedule;
use Reflex\Models\Target;
use Auth;
use Reflex\Models\Visit;

class TargetController extends Controller {

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

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function main()
    {
        $user = Auth::user();
        $zone = Auth::user()->zones->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        return view('frontend.target', compact('user','zone','campaign'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function preview($id)
    {
        Log::info('id previewed: '.$id);

        $target = Target::with('client',
            'client.location','zone','user',
            'campaign','company','client.client_type','client.category','client.place',
            'client.hobby',
            'client.specialty_base','client.specialty_target','client.university')->find($id);

        $schedules = Schedule::with('zone','client')
            ->where('client_id', '=',$target->client_id)->orderBy('day', 'ASC')->get();

        $note_types_options = DB::table('note_types')
            ->where('code','=','AAC')
            ->orWhere('code','=','INF')
            ->orWhere('code','=','OBJ')
            ->orderBy('name','asc')
            ->lists('name','id');
        $visits = Visit::with('visit_type')->where('target_id','=',$target->id)->where('visit_status_id','=',1)->get();

        return view('frontend.target_preview', compact('target','schedules','note_types_options','visits'));

    }

}
