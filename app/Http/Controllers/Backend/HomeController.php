<?php namespace Reflex\Http\Controllers\Backend;

use Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Reflex\Models\BusinessUnit;
use Reflex\Models\Company;
use Reflex\Models\SubBusinessUnit;
use Reflex\Http\Controllers\Controller;
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

    private $responseFactory;

	/**
	 * Create a new controller instance.
	 @param ResponseFactory $responseFactory
	 */
	public function __construct(ResponseFactory $responseFactory)
	{
		$this->middleware('auth');
        $this->responseFactory = $responseFactory;
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


		return view('backend.home', array('user' => $user,'company' => $company, 'businessUnits' => $businessUnits));
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
        return view('backend.sub_business_unit', array('businessUnit' => $businessUnit, 'subBusinessUnits' => $subBusinessUnits));
    }

    public function category_report()
    {
        $cat[] = array('label' => 'Vip','value' => DB::table('clients')->where('category_id','=',1)->count());
        $cat[] = array('label' => 'A','value' => DB::table('clients')->where('category_id','=',2)->count());
        $cat[] = array('label' => 'B','value' => DB::table('clients')->where('category_id','=',3)->count());

        returN $this->responseFactory->json($cat);
    }

    public function place_report()
    {
        $cat[] = array('label' => 'AM','value' => DB::table('clients')->where('place_id','=',1)->count());
        $cat[] = array('label' => 'PM','value' => DB::table('clients')->where('place_id','=',2)->count());

        returN $this->responseFactory->json($cat);
    }

    public function client_type_report()
    {
        $cat[] = array('label' => 'Doctores','value' => DB::table('clients')->where('client_type_id','=',1)->count());
        $cat[] = array('label' => 'Farmacia','value' => DB::table('clients')->where('client_type_id','=',2)->count());
        $cat[] = array('label' => 'Clínica','value' => DB::table('clients')->where('client_type_id','=',3)->count());
        $cat[] = array('label' => 'Hospital','value' => DB::table('clients')->where('client_type_id','=',4)->count());

        returN $this->responseFactory->json($cat);
    }

    public function client_specialty()
    {

        $data = DB::table('clients')->select(DB::raw('specialties.name as label, count(1) as value'))
            ->join('specialties', 'clients.specialty_base_id', '=', 'specialties.id')
            ->groupBy('specialties.name')->get();

        returN $this->responseFactory->json($data);
    }


}
