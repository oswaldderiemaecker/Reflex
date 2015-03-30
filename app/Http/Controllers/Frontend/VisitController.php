<?php namespace Reflex\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Reflex\Models\Target;
use Reflex\Models\Visit;
use Webpatser\Uuid\Uuid;
use Auth;
use DB;

class VisitController extends Controller {

    protected $visit;
    private $responseFactory;

    public function __construct(Visit $visit, ResponseFactory $responseFactory)
    {
        $this->visit = $visit;
        $this->responseFactory = $responseFactory;
    }
	/**
	 * Display a listing of the resource.
	 *
     * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
        $zone_id     = $request->get('zone_id',null,true);
        $user_id     = $request->get('user_id',null,true);
        $campaign_id = $request->get('campaign_id',null,true);
        $query_in = $request->get('query',null,true);

        $targets =  $this->visit->newQuery()->with('target','client','client.location','client.category','client.place');
        $targets->where('zone_id','=', $zone_id);
        $targets->where('visit_status_id','=', '2');

        if(!(is_null($zone_id) || $zone_id == '')){
            $targets->where('zone_id','=', $zone_id);
        }

        if(!(is_null($user_id) || $user_id == '')){
            $targets->where('user_id','=', $user_id);
        }

        if(!(is_null($campaign_id) || $campaign_id == '')){
            $targets->where('campaign_id','=', $campaign_id);
        }

        if(!(is_null($query_in) || $query_in == '')){

            $targets->whereHas('client', function($q) use($query_in){
                $q->where('closeup_name','LIKE','%'.strtoupper($query_in).'%');
            });
        }

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
        $target = Target::with('client')->find($target_id);

        $visit->uuid = Uuid::generate();
        $visit->route_uuid      = $route_uuid;
        $visit->visit_type_id   = $visit_type_id;
        $visit->visit_status_id = $visit_status_id;
        $visit->reason_id       = $reason_id;
        $visit->zone_id         = $target->zone_id;
        $visit->user_id         = $target->user_id;
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

        $visit = Visit::find($id);

        $target = Target::with('client')->find($visit->target_id);

        $visit->route_uuid      = $route_uuid;
        $visit->visit_type_id   = $visit_type_id;
        $visit->visit_status_id = $visit_status_id;
        $visit->reason_id       = $reason_id;
        $visit->zone_id         = $target->zone_id;
        $visit->user_id         = $target->user_id;
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
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $visit = Visit::find($id);
        $target = Target::with('client')->find($visit->target_id);

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
            $is_supervised   = $request->get('is_supervised',null,true);
            $is_from_mobile  = $request->get('is_from_mobile',null,true);
            $active          = 0;
            $longitude       = $request->get('longitude',null,true);
            $latitude        = $request->get('latitude',null,true);


            $visit->route_uuid      = $route_uuid;
            $visit->visit_type_id   = $visit_type_id;
            $visit->visit_status_id = $visit_status_id;
            $visit->reason_id       = $reason_id;
            $visit->zone_id         = $target->zone_id;
            $visit->user_id         = $target->user_id;
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

	}

    public function main()
    {
        $user = Auth::user();
        $zone = Auth::user()->zones->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        return view('frontend.visit', compact('user','zone','campaign'));
    }

    public function visit_new(Request $request)
    {
        $uuid   = $request->get('uuid',null,true);
        $visit = Visit::with('target','client')->find($uuid);
        $start = Carbon::now();

        return view('frontend.visit_new', compact('visit','start'));
    }


    public function visit_preview($id)
    {
        $visit = $this->visit->findOrFail($id);


        return view('frontend.visit_preview', compact('visit'));
    }

}
