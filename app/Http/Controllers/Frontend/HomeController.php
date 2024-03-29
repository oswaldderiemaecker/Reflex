<?php namespace Reflex\Http\Controllers\Frontend;

use Auth;
use Carbon;
use DB;
use Excel;
use File;
use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Assignment;
use Reflex\Models\BusinessUnit;
use Reflex\Models\Campaign;
use Reflex\Models\Company;
use Reflex\Models\Visit;
use Reflex\Models\Zone;
use Reflex\User;
use Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller {

    private $responseFactory;
    private $zone;
    private $campaign;
    private $assignment;

    /**
     * Create a new controller instance.
     * @param ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->middleware('auth');
        $this->responseFactory = $responseFactory;

        $this->campaign = Campaign::where('active','=',1)->first();

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $id = Auth::user()->id;
        $user = User::find($id);

        $campaign = Campaign::where('active','=',1)->where('company_id','=',$user->company_id)->first();

        $this->assignment = Assignment::with('zone')->where('campaign_id','=',$campaign->id)
            ->where('user_id','=',$user->id)->first();

        $this->zone = Zone::find($this->assignment->zone_id);

        //print_r($this->zone->toArray());

        //print_r($this->assignment->toArray());
        //die;
        $targets   = DB::table('clients')->where('zone_id','=',$this->zone->id)->count();
        $targets   = ($targets == 0)?1:$targets;
        $visits    = DB::table('visits')->where('visit_status_id','=','2')->where('assignment_id','=',$this->assignment->id)->count();

        $absences  = DB::table('visits')->where('zone_id','=',$this->zone->id)->where('user_id','=',$user->id)
            ->where('visits.visit_status_id','=','3')
            ->where('visits.assignment_id','=',$this->assignment->id)->count();
        $coverage  = round( $visits*100/$targets, 2, PHP_ROUND_HALF_ODD);

        $counters = array('targets' => $targets, 'visits' => $visits,'absences' => $absences,'coverage' => $coverage);

        $businessUnits = BusinessUnit::with('company','sub_business_units')->where('company_id', '=', $user->company_id)->get();
        $company = Company::find($user->company_id);

        $last_visits = Visit::with('client')
            ->where('zone_id','=',$this->zone->id)
            ->where('user_id','=',Auth::user()->id)
            ->where('campaign_id','=',$campaign->id)
            ->where('visit_status_id','=','2')
            ->orderBy('start','desc')
            ->take(8)->get();

        return view('frontend.home', compact('user','company','businessUnits','counters','last_visits','campaign'));
	}

    public function map()
    {
        $user = Auth::user();
        $this->assignment = Auth::user()->assignments()->first();
        $this->zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();
        $zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();
        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        return view('frontend.route.map', compact('user','zone','campaign'));
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


    //API REPORT METHODS

    public function coverage_export()
    {
        $id = Auth::user()->id;
        $this->assignment = Auth::user()->assignments()->first();
        $this->zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();
        $date = Carbon::now()->toDateTimeString();

        $targets   = DB::table('clients')->where('zone_id','=',$this->zone->id)->count();
        $visits    = DB::table('visits')
            ->where('zone_id','=',$this->zone->id)
            ->where('user_id','=',$id)
            ->where('visits.visit_status_id','=','2')->count();
        $absences  = DB::table('visits')
            ->where('zone_id','=',$this->zone->id)
            ->where('user_id','=',$id)
            ->where('visits.visit_status_id','=','3')->count();
        $coverage  = round( $visits*100/$targets, 2, PHP_ROUND_HALF_ODD);

        $counters =
            array(

                array(
            'usuario' => Auth::user()->closeup_name,
            'ciclo' => $this->campaign->name,
            'target' => $targets,
            'visitas' => $visits, 'ausencias' => $absences,
                    'cobertura' => $coverage.' %',
                    'fecha' => $date
                ));



        $data = json_decode(json_encode((array) $counters), true);

        //print_r(count($visits));

        Excel::create('cobertura_'.$date, function($excel) use($data) {
            $excel->sheet('datos', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('pdf');
    }

    public function visit_status()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        $campaign = Campaign::where('active','=',1)->where('company_id','=',$user->company_id)->first();

        $assignment = Assignment::with('zone')->where('campaign_id','=',$campaign->id)
            ->where('user_id','=',$user->id)->first();

        $data = DB::table('visits')->select(DB::raw('visit_status.name as label, count(1) as value'))
            ->join('visit_status', 'visits.visit_status_id', '=', 'visit_status.id')
            ->where('visits.assignment_id','=',$assignment->id)
            ->where('visits.campaign_id','=',$campaign->id)
          //  ->where('visits.visit_status_id','=','2')
            ->groupBy('visit_status.name')->get();

        returN $this->responseFactory->json($data);
    }

    public function client_specialty()
    {
        $user = Auth::user();
        $this->assignment = Auth::user()->assignments()->first();
        $this->zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();

        $data = DB::table('targets')->select(DB::raw('specialties.name as label, count(1) as value'))
            ->join('clients', 'targets.client_id', '=', 'clients.id')
            ->join('assignments', 'assignments.id', '=', 'targets.assignment_id')
            ->join('specialties', 'clients.specialty_base_id', '=', 'specialties.id')
            ->where('assignments.user_id', '=', $user->id)
            ->where('assignments.zone_id', '=', $this->zone->id)
            ->where('targets.campaign_id','=',$this->campaign->id)
            ->groupBy('specialties.name')->get();

        returN $this->responseFactory->json($data);
    }

    public function category_report()
    {
        $this->assignment = Auth::user()->assignments()->first();
        $this->zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();
        $cat[] = array('label' => 'Vip','value' => DB::table('clients')->where('category_id','=',1)->where('zone_id','=',$this->zone->id)->count());
        $cat[] = array('label' => 'A','value' => DB::table('clients')->where('category_id','=',2)->where('zone_id','=',$this->zone->id)->count());
        $cat[] = array('label' => 'B','value' => DB::table('clients')->where('category_id','=',3)->where('zone_id','=',$this->zone->id)->count());

        returN $this->responseFactory->json($cat);
    }

    public function place_report()
    {
        $this->assignment = Auth::user()->assignments()->first();
        $this->zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();
        $cat[] = array('label' => 'AM','value' => DB::table('clients')->where('place_id','=',1)->where('zone_id','=',$this->zone->id)->count());
        $cat[] = array('label' => 'PM','value' => DB::table('clients')->where('place_id','=',2)->where('zone_id','=',$this->zone->id)->count());

        returN $this->responseFactory->json($cat);
    }

    public function client_type_report()
    {
        $this->assignment = Auth::user()->assignments()->first();
        $this->zone = DB::table('zones')->where('id', '=', $this->assignment->zone_id)->first();
        $cat[] = array('label' => 'Doctores','value' => DB::table('clients')->where('client_type_id','=',1)->where('zone_id','=',$this->zone->id)->count());
        $cat[] = array('label' => 'Farmacia','value' => DB::table('clients')->where('client_type_id','=',2)->where('zone_id','=',$this->zone->id)->count());
        $cat[] = array('label' => 'Clínica','value' => DB::table('clients')->where('client_type_id','=',3)->where('zone_id','=',$this->zone->id)->count());
        $cat[] = array('label' => 'Hospital','value' => DB::table('clients')->where('client_type_id','=',4)->where('zone_id','=',$this->zone->id)->count());

        returN $this->responseFactory->json($cat);
    }

    /**
     * Get image and validate with cmp.
     *
     * @param  String  $cmp
     * @return Response
     */
    public function image_client($cmp)
    {
        $cmp = substr('00000'.$cmp,-5);
        $path = public_path().'/pictures/'.$cmp.'.jpg';

        if (!File::exists($path))
        {

            $path = public_path().'/images/avatar.png';
        }

        return $this->responseFactory->make( File::get( $path ) , 200, array('Content-Type' => File::type($path)) );
    }


}
