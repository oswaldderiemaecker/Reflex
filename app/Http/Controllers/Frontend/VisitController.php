<?php namespace Reflex\Http\Controllers\Frontend;

use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Reason;
use Reflex\Models\Target;
use Reflex\Models\Visit;
use Reflex\Models\VisitStatus;
use Webpatser\Uuid\Uuid;

class VisitController extends Controller {

    protected $visit;
    private $responseFactory;

    public function __construct(Visit $visit, ResponseFactory $responseFactory)
    {
        $this->visit = $visit;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param $companyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function social($companyId){

        $records = DB::table('visits')->select(DB::raw('visits.uuid,users.closeup_name as user, users.photo,
                clients.code as cmp,clients.closeup_name as client,
                visits.start,visits.end,visits.is_supervised,locations.name as location,
                specialties.code as specialty,visits.latitude, visits.longitude'))
            ->join('targets', 'visits.target_id', '=', 'targets.id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->join('clients', 'targets.client_id', '=', 'clients.id')
            ->join('locations', 'clients.location_id', '=', 'locations.id')
            ->join('specialties', 'clients.specialty_base_id', '=', 'specialties.id')
            ->where('targets.company_id','=',$companyId)
            ->where('visits.visit_status_id','=',2)
            ->whereRaw('Extract(DAY from visits.start) = Extract(DAY from now()) ')
            ->whereRaw('Extract(YEAR from visits.start) = Extract(YEAR from now()) ')
            ->whereRaw('Extract(MONTH from visits.start) = Extract(MONTH from now()) ')
            ->orderBy('visits.start')->get();

        return $this->responseFactory->json($records);
    }
	/**
	 * Display a listing of the resource.
	 *
     * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
        $assignment_id = $request->get('assignment_id', null, true);
        $zone_id       = $request->get('zone_id',null,true);
        $campaign_id   = $request->get('campaign_id',null,true);
        $client_id     = $request->get('client_id',null,true);
        $user_id       = $request->get('user_id',null,true);
        $visit_status_id = $request->get('visit_status_id',null,true);
        $query_in = $request->get('query',null,true);

        $targets =  $this->visit->newQuery()->with('client','client.location','client.category','client.place');

        if(!(is_null($assignment_id) || $assignment_id == '')){
            $targets->where('assignment_id','=', $assignment_id);
        }

        if(!(is_null($zone_id) || $zone_id == '')){
            $targets->where('zone_id','=', $zone_id);
        }

        if(!(is_null($user_id) || $user_id == '')){
            $targets->where('user_id','=', $user_id);
        }

        if(!(is_null($campaign_id) || $campaign_id == '')){
            $targets->where('campaign_id','=', $campaign_id);
        }

        if(!(is_null($visit_status_id) || $visit_status_id == '' || $visit_status_id == 0)){
            $targets->where('visit_status_id','=', $visit_status_id);
        }

        if(!(is_null($client_id) || $client_id == '')){
            $targets->where('client_id','=', $client_id);
        }

        if(!(is_null($query_in) || $query_in == '')){

            $targets->whereHas('client', function($q) use($query_in){
                $q->where('closeup_name','LIKE','%'.strtoupper($query_in).'%');
            });
        }
        $targets->orderBy('created_at');

        return $targets->get()->toJson();
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
     * only for aditional visits
	 *
     * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $route_uuid      = $request->get('route_uuid',null,true);
        $visit_type_id   = $request->get('visit_type_id',null,true);
        $target_id       = $request->get('target_id',null,true);
        $visit_status_id = $request->get('visit_status_id',null,true);
        $reason_id       = $request->get('reason_id',null,true);
        $start           = $request->get('start',null,true);
        $end             = $request->get('end',null,true);
        $supervisor      = $request->get('supervisor',null,true);
        $cmp             = $request->get('cmp',null,true);
        $firstname       = $request->get('firstname',null,true);
        $lastname        = $request->get('lastname',null,true);
        $is_supervised   = $request->get('is_supervised',null,true);
        $is_from_mobile  = $request->get('is_from_mobile',null,true);
        $active          = $request->get('active',null,true);
        $longitude       = $request->get('longitude',null,true);
        $latitude        = $request->get('latitude',null,true);

        $visit = new Visit();
        $target = Target::with('client', 'assignment')->find($target_id);

        $visit->uuid = Uuid::generate();
        $visit->route_uuid      = $route_uuid;
        $visit->visit_type_id   = $visit_type_id;
        $visit->visit_status_id = $visit_status_id;
        $visit->reason_id       = $reason_id;
        $visit->zone_id = $target->assignment->zone_id;
        $visit->user_id = $target->assignment->user_id;
        $visit->campaign_id     = $target->campaign_id;
        $visit->target_id       = $target->id;
        $visit->specialty_id    = $target->client->specialty_base_id;
        $visit->client_id       = $target->client_id;
        $visit->start           = $start;
        $visit->end             = $end;
        $visit->supervisor      = $supervisor;
        $visit->cmp             = $cmp;
        $visit->firstname       = $firstname;
        $visit->lastname        = $lastname;
        $visit->is_supervised   = $is_supervised;
        $visit->is_from_mobile  = $is_from_mobile;
        $visit->active          = $active;
        $visit->longitude       = $longitude;
        $visit->latitude        = $latitude;

        $visit-save();

        return $this->responseFactory->json($visit);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $visit = $this->visit->findOrFail($id);
        return $this->responseFactory->json($visit);
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
     * @param Request $request
	 * @param int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $route_uuid      = $request->get('route_uuid',null,true);
        $visit_type_id   = $request->get('visit_type_id',null,true);
        $visit_status_id = $request->get('visit_status_id',null,true);
        $reason_id       = $request->get('reason_id',null,true);
        $start           = $request->get('start',null,true);
        $end             = $request->get('end',null,true);
        $supervisor      = $request->get('supervisor',null,true);
        $description     = $request->get('description',null,true);
        $cmp             = $request->get('cmp',null,true);
        $firstname       = $request->get('firstname',null,true);
        $lastname        = $request->get('lastname',null,true);
        $is_supervised   = $request->get('is_supervised',null,true);
        $is_from_mobile  = $request->get('is_from_mobile',null,true);
        $active          = $request->get('active',null,true);
        $longitude       = $request->get('longitude',null,true);
        $latitude        = $request->get('latitude',null,true);

        $visit = Visit::with('client','client.location','client.category','client.place')->find($id);

        $target = Target::with('client')->find($visit->target_id);

        $visit->route_uuid      = $route_uuid;
        $visit->visit_type_id   = $visit_type_id;
        $visit->visit_status_id = $visit_status_id;
        $visit->reason_id       = $reason_id;
        $visit->zone_id = $target->assignment->zone_id;
        $visit->user_id = $target->assignment->user_id;
        $visit->campaign_id     = $target->campaign_id;
        $visit->target_id       = $target->id;
        $visit->specialty_id    = $target->client->specialty_base_id;
        $visit->client_id       = $target->client_id;
        $visit->start           = $start;
        $visit->end             = $end;
        $visit->supervisor      = $supervisor;
        $visit->description     = $description;
        $visit->cmp             = $cmp;
        $visit->firstname       = $firstname;
        $visit->lastname        = $lastname;
        $visit->is_supervised   = $is_supervised;
        $visit->is_from_mobile  = $is_from_mobile;
        $visit->active          = $active;
        $visit->longitude       = $longitude;
        $visit->latitude        = $latitude;

        $visit->save();

        return $this->responseFactory->json($visit);
	}

	/**
	 * Remove the specified resource from storage.
	 *
     * @param Request $request
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
        $visit = Visit::with('client','client.location','client.category','client.place')->find($id);
        $target = Target::with('client', 'assignment')->find($visit->target_id);

        if($visit->visit_type_id == 2)
        {
            $visit->delete();
            return $this->responseFactory->json('ok');

        }else{
            $route_uuid      = $request->get('route_uuid',null,true);
            $visit_type_id   = 1;
            $visit_status_id = 1;
            $reason_id       = $request->get('reason_id',null,true);
            $start           = $request->get('start',null,true);
            $end             = $request->get('end',null,true);
            $supervisor      = $request->get('supervisor',null,true);
            $cmp             = $request->get('cmp',null,true);
            $firstname       = $request->get('firstname',null,true);
            $lastname        = $request->get('lastname',null,true);
            $is_supervised   = $request->get('is_supervised',false,true);
            $is_from_mobile  = $request->get('is_from_mobile',false,true);
            $active          = false;
            $longitude       = $request->get('longitude',null,true);
            $latitude        = $request->get('latitude',null,true);


            $visit->route_uuid      = $route_uuid;
            $visit->visit_type_id   = $visit_type_id;
            $visit->visit_status_id = $visit_status_id;
            $visit->reason_id       = $reason_id;
            $visit->specialty_id    = $target->client->specialty_base_id;
            $visit->client_id       = $target->client_id;
            $visit->start           = $start;
            $visit->end             = $end;
            $visit->supervisor      = $supervisor;
            $visit->cmp             = $cmp;
            $visit->firstname       = $firstname;
            $visit->lastname        = $lastname;
            $visit->is_supervised   = false;
            $visit->is_from_mobile  = false;
            $visit->active          = $active;
            $visit->longitude       = $longitude;
            $visit->latitude        = $latitude;
            $visit->save();

            return $this->responseFactory->json($visit);
        }

	}

    public function main()
    {
        $user = Auth::user();
        $assignment = Auth::user()->assignments->first();
        $zone = DB::table('zones')->where('id', '=', $assignment->zone_id)->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        return view('frontend.visit.visit', compact('user','zone','campaign'));
    }

    public function visit_new(Request $request)
    {
        $uuid   = $request->get('uuid',null,true);
        $visit = Visit::with('target','client')->find($uuid);
        $start = Carbon::now();

        return view('frontend.visit.visit_new', compact('visit','start'));
    }


    public function visit_preview($id)
    {
        $visit = $this->visit->findOrFail($id);


        return view('frontend.visit.visit_preview', compact('visit'));
    }

    public function absence_new(Request $request)
    {
        $uuid   = $request->get('uuid',null,true);
        $visit = Visit::with('target','client')->find($uuid);
        $start = Carbon::now();
        $reasons = Reason::all();

        return view('frontend.visit.absence_new', compact('visit','start','reasons'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function export(Request $request)
    {
        $zone_id         = $request->get('zone_id',null,true);
        $campaign_id     = $request->get('campaign_id',null,true);
        $visit_status_id = $request->get('visit_status_id',null,true);

        $user_id = $request->get('user_id',null,true);

        $date = Carbon::now()->toDateTimeString();

        $visit_status = VisitStatus::find($visit_status_id);

        $visits = DB::table('visits')
            ->join('zones'       ,'visits.zone_id'        ,'=','zones.id')
            ->join('visit_status','visits.visit_status_id','=','visit_status.id')
            ->join('visit_types' ,'visits.visit_type_id'  ,'=','visit_types.id')
            ->leftJoin('reasons' ,'visits.reason_id'  ,'=','reasons.id')
            ->join('users'       ,'visits.user_id'        ,'=','users.id')
            ->join('campaigns'   ,'visits.campaign_id'    ,'=','campaigns.id')
            ->join('clients'     ,'visits.client_id'      ,'=','clients.id')
            ->join('categories'  ,'categories.id'         ,'=','clients.category_id')
            ->join('places'      ,'places.id'             ,'=','clients.place_id')
            ->join('locations'   ,'clients.location_id'   ,'=','locations.id')
            ->select('campaigns.name as ciclo',
                'visit_types.name as tipo',
                'visit_status.name as estado',
                'zones.name as zona',
                'users.closeup_name as usuario',
                'clients.closeup_name as doctor',
                'clients.address as direccion',
                'locations.name as distrito',
                'categories.name as categoria',
                'places.name as lugar',
                'visits.start as inicio',
                'visits.end as fin',
                'visits.is_supervised as supervisado',
                'visits.description as descripcion',
                'reasons.name as motivo'
            )
            ->where('visits.zone_id','=',$zone_id)
            ->where('visits.campaign_id','=',$campaign_id)
            ->where('visits.user_id','=',$user_id)
            ->where('visits.visit_status_id','=',$visit_status_id)
            ->whereNull('visits.deleted_at')
            ->orderBy('visits.start','desc')
            ->get();

        $data = json_decode(json_encode((array) $visits), true);

        //print_r(count($visits));

        Excel::create('Backup_'.$visit_status->name.'-'.$date, function($excel) use($data) {
            $excel->sheet('datos', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    /**
     * @param $clientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function historical($clientId){

        $records = DB::table('visits')->select(DB::raw('campaigns.code as campaign, visits.is_supervised,visits.start,
        visits.visit_status_id'))
            ->join('campaigns', 'visits.campaign_id', '=', 'campaigns.id')
            ->where('visits.client_id','=',$clientId)
            ->orderBy('campaigns.code')->get();

        return $this->responseFactory->json($records);
    }

}
