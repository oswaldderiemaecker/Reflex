<?php namespace Reflex\Http\Controllers\Frontend;

use Auth;
use Carbon\Carbon;
use Excel;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Route;
use Reflex\Models\Target;
use Uuid;

class RouteController extends Controller {

    protected $route;
    private $responseFactory;

    public function __construct(Route $route, ResponseFactory $responseFactory)
    {
        $this->route = $route;
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
        $page = 20;
        $zone_id     = $request->get('zone_id',null,true);
        $user_id     = $request->get('user_id',null,true);
        $start       = $request->get('start',null,true);
        $end         = $request->get('end',null,true);
        $campaign_id = $request->get('campaign_id',null,true);
        $query_in = $request->get('query',null,true);

        $targets =  $this->route->newQuery()->with('target','client','client.location','client.category','client.place');
        $targets->where('zone_id','=', $zone_id);

        if(!(is_null($zone_id) || $zone_id == '')){
            $targets->where('zone_id','=', $zone_id);
        }

        if(!(is_null($start) || $start == ''))
        {
            $targets->where('start','>=',$start);
        }

        if(!(is_null($end) || $end == ''))
        {
            $targets->where('start','<=',$end);
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

        $targets->whereNull('deleted_at');
        $targets->orderBy('start','asc');

        return $this->responseFactory->json($targets->paginate($page));
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
     * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $zone_id     = $request->get('zone_id',null,true);
        $target_id     = $request->get('target_id',null,true);
        $start         = $request->get('start',null,true);
        $end         = $request->get('end',null,true);
        $description  = $request->get('description',null,true);
        $point_of_contact = $request->get('point_of_contact',null,true);
        $is_from_mobile = $request->get('is_from_mobile',null,true);

        $target = Target::with('client', 'assignment')->find($target_id);

        $uuid = Uuid::generate();

        $route = Route::create(array(
            'uuid' => $uuid,
            'assignment_id' => $target->assignment_id,
            'zone_id' => $zone_id,
            'user_id' => $target->assignment->user_id,
            'campaign_id' => $target->campaign_id,
            'target_id' => $target_id,
            'client_id' => $target->client_id,
            'start' => $start,
            'end' => $end,
            'description' => $description,
            'point_of_contact' => (($point_of_contact == '1')?true:false),
            'is_from_mobile' => $is_from_mobile
        ));

        return $this->responseFactory->json($this->route->find($uuid));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $route = $this->route->findOrFail($id);
        return $this->responseFactory->json($route);
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $start = $request->get('start',null,true);
        $end   = $request->get('end',null,true);

        $route = Route::find($id);
        $route->start = $start;
        $route->end = $end;

        $route->save();
        return $this->responseFactory->json($route);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->route->findOrFail($id)->delete();
	}

    public function main()
    {
        $user = Auth::user();
        $assignment = Auth::user()->assignments->first();
        $zone = DB::table('zones')->where('id', '=', $assignment->zone_id)->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        return view('frontend.route.route',compact('zone','user','campaign'));
    }

    public function calendar(Request $request)
    {
        $target_id   = $request->get('target_id',null,true);
        $zone_id     = $request->get('zone_id',null,true);
        $user_id     = $request->get('user_id',null,true);
        $campaign_id = $request->get('campaign_id',null,true);
        $start       = $request->get('start',null,true);
        $end         = $request->get('end',null,true);
        $point_of_contact = $request->get('point_of_contact',null,true);

        $result = null;
        $data = Route::with('client','client.location');
        $data->where('zone_id','=',$zone_id);
        $data->where('campaign_id','=',$campaign_id);

        if(!(is_null($user_id) || $user_id == '')){
            $data->where('user_id','=',$user_id);
        }

        if(!(is_null($target_id) || $target_id == '')){
            $data->where('target_id','=',$target_id);
        }

        if(!(is_null($start) || $start == '')){
            $data->where('start','>=',$start);
        }

        if(!(is_null($end) || $end == '')){
            $data->where('end','<=',$end);
        }

        if(!(is_null($point_of_contact) || $point_of_contact == '')){
            $data->where('point_of_contact','=',$point_of_contact);
        }

        $data->whereNull('deleted_at');
        $routes = $data->get();

        foreach($routes as $dato)
        {
            $result[] = array
            (
                'id' => $dato->uuid,
                'uuid' => $dato->uuid,
                'target_id' => $dato->target_id,
                'point_of_contact' => $dato->point_of_contact,
                'title' => $dato->client->closeup_name, //."\n".$dato->client->address,
                'start' => $dato->start,
                'end' => $dato->end,
                'address' => $dato->client->address.' '.$dato->client->location->name,
                'color' => (($dato->point_of_contact == '1')?'#F4543C':'#0073B7'),
                'allDay' => false
            );
        }

        return $this->responseFactory->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function export(Request $request)
    {
        $zone_id     = $request->get('zone_id',null,true);
        $campaign_id = $request->get('campaign_id',null,true);
        $user_id = $request->get('user_id',null,true);

        $date = Carbon::now()->toDateTimeString();

        $routes = DB::table('routes')
            ->join('zones','routes.zone_id','=','zones.id')
            ->join('users','routes.user_id','=','users.id')
            ->join('campaigns','routes.campaign_id','=','campaigns.id')
            ->join('clients','routes.client_id','=','clients.id')
            ->join('locations','clients.location_id','=','locations.id')
            ->select('campaigns.name as ciclo',
                'zones.name as zona',
                'users.closeup_name as usuario',
                'clients.closeup_name as doctor',
                'clients.address as direccion',
                'locations.name as distrito',
                'routes.start as inicio',
                'routes.end as fin'
            )
            ->where('routes.zone_id','=',$zone_id)
            ->where('routes.campaign_id','=',$campaign_id)
            ->where('routes.user_id','=',$user_id)
            ->whereNull('routes.deleted_at')
            ->orderBy('routes.start','desc')
            ->get();

        $data = json_decode(json_encode((array) $routes), true);

        Excel::create('backup_rutas_'.$date, function($excel) use($data) {
            $excel->sheet('rutas', function($sheet) use($data) {
                $sheet->fromArray($data);
            });

        })->export('xls');
    }



}
