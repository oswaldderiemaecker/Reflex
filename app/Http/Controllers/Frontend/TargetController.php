<?php namespace Reflex\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;
use Carbon;
use Reflex\Models\Schedule;
use Reflex\Models\Target;
use Auth;
use Excel;
use Reflex\Models\Visit;
use Symfony\Component\HttpFoundation\Request;

class TargetController extends Controller
{

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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
        $campaign = DB::table('campaigns')->where('active', '=', 1)->first();

        return view('frontend.target.target', compact('user', 'zone', 'campaign'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function preview($id)
    {
        Log::info('id previewed: ' . $id);

        $target = Target::with('client',
            'client.location', 'zone', 'user',
            'campaign', 'company', 'client.client_type', 'client.category', 'client.place',
            'client.hobby',
            'client.specialty_base', 'client.specialty_target', 'client.university')->find($id);

        $schedules = Schedule::with('zone', 'client')->where('client_id', '=', $target->client_id )->orderBy('day', 'ASC')->get();

        $note_types_options = DB::table('note_types')
            ->where('code', '=', 'AAC')
            ->orWhere('code', '=', 'INF')
            ->orWhere('code', '=', 'OBJ')
            ->orderBy('name', 'asc')
            ->lists('name', 'id');

        $visits = Visit::with('visit_type')->where('target_id', '=', $target->id)->where('visit_status_id', '=', 1)->get();

        $allVisits = Visit::with('user','campaign')->where('client_id', '=', $target->client_id)->get();

        return view('frontend.target.target_preview', compact('target', 'schedules', 'note_types_options', 'visits','allVisits'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $zone_id
     * @param  int $campaign_id
     * @param  int $user_id
     * @return Response
     */
    public function target_export($zone_id, $campaign_id, $user_id)
    {

        //print_r($request->get('zone_id', null, true));
        //$zone_id     = $request->get('zone_id', null, true);
        //$campaign_id = $request->get('campaign_id', null, true);
        //$user_id     = $request->get('user_id', null, true);

        //die($zone_id);


        $date = Carbon::now()->toDateTimeString();

        $targets = DB::table('targets')
            ->join('zones'     , 'targets.zone_id'     , '=', 'zones.id')
            ->join('users'     , 'targets.user_id'     , '=', 'users.id')
            ->join('campaigns' , 'targets.campaign_id' , '=', 'campaigns.id')
            ->leftJoin('clients'   , 'targets.client_id'   , '=', 'clients.id')
            ->join('categories', 'categories.id'       , '=', 'clients.category_id')
            ->join('places'    , 'places.id'           , '=', 'clients.place_id')
            ->leftJoin('locations' , 'clients.location_id' , '=', 'locations.id')
            ->select('campaigns.name as ciclo',
                'zones.name as zona',
                'users.closeup_name as usuario',
                'clients.closeup_name as doctor',
                'clients.address as direccion',
                'locations.name as distrito',
                'categories.name as categoria',
                'places.name as tarea'
            )
            ->where('targets.zone_id', '=', $zone_id)
            ->where('targets.campaign_id', '=', $campaign_id)
            ->where('targets.user_id', '=', $user_id)
            ->whereNull('targets.deleted_at')
            ->orderBy('clients.closeup_name', 'desc')
            ->get();

        $data = json_decode(json_encode((array)$targets), true);

        //print_r($data);
        //die();

        Excel::create('Backup_target_' . $date, function ($excel) use ($data) {
            $excel->sheet('target', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

}
