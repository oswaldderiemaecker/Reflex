<?php namespace Reflex\Http\Controllers\Backend;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Input;
use Log;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Campaign;
use Reflex\Models\Target;
use Reflex\Models\Zone;
use Reflex\User;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class TargetController extends Controller {

    protected $target;
    protected $responseFactory;

    public function __construct(Target $target, ResponseFactory $responseFactory)
    {
        $this->target = $target;
        $this->responseFactory = $responseFactory;
    }
	/**
	 * Display a listing of the resource.
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
        $zone_id       = $request->get('zone_id',null,true);
        $assignment_id = $request->get('assignment_id',null,true);
        $user_id       = $request->get('user_id',null,true);
        $campaign_id   = $request->get('campaign_id',null,true);
        $query_in      = $request->get('query',null,true);

        $targets       = $this->target->newQuery()->with('assignment', 'client', 'client.location', 'client.category', 'client.place');

        if(!(is_null($zone_id) || $zone_id == '')){

            $targets->whereHas('assignment', function ($q) use ($zone_id) {
                $q->where('zone_id', '=', $zone_id);
            });
        }

        if(!(is_null($user_id) || $user_id == '')){
            $targets->whereHas('assignment', function ($q) use ($user_id) {
                $q->where('user_id', '=', $user_id);
            });
        }

        if(!(is_null($campaign_id) || $campaign_id == '')){
            $targets->where('campaign_id','=', $campaign_id);
        }

        if(!(is_null($assignment_id) || $assignment_id == '')){
            $targets->where('assignment_id','=', $assignment_id);
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
        $target = $this->target->newQuery()->with('company','campaign','assignment','client',
            'client.location',
            'client.client_type', 'client.category', 'client.place',
            'client.hobby',
            'client.specialty_base', 'client.specialty_target', 'client.university'
            )->find($id);
        return $this->responseFactory->json($target);
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

    public function getIndex()
    {

        $filter = DataFilter::source($this->target->newQuery()->with('assignment', 'company', 'campaign', 'assignment.zone', 'assignment.user', 'client')->take(1000));

       //s $filter->add('company.name','Empresa', 'text');
        $filter->add('campaign.name','Ciclo', 'select')->options(Campaign::lists('name', 'id'));
        $filter->add('assignment.zone.name', 'Zona', 'autocomplete')->options(Zone::lists('name', 'id'));
        $filter->add('assignment.user.name', 'Usuario', 'autocomplete')->options(User::lists('closeup_name', 'id'));
        $filter->add('assignment.user.firstname', 'Nombre', 'text');
        $filter->add('assignment.user.lastname', 'Apellido', 'text');
        //$filter->add('client.category_id','Categoria','select')->options(Category::lists('name', 'id'));
        //$filter->add('client.place_id','Tarea','select')->options(Place::lists('name', 'id'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        //$grid->add('company.name','Empresa',false);
        $grid->add('campaign.name','Ciclo',false);
        $grid->add('assignment.zone.name', 'Zona', false);
        $grid->add('{{ $assignment->user->firstname." ".$assignment->user->lastname }}', 'Usuario', false);
        $grid->add('{{ $client->firstname." ".$client->lastname }}', 'Cliente', false);
        $grid->add('client.category.code','Cat',false);
        $grid->add('client.place.code','Tar',false);
        $grid->add('qty_visits','# Vis',true);

        $grid->edit('/backend/targets/edit', 'Mostrar','modify');
        //$grid->link('targets/edit',"Nueva Zona", "TR");
        $grid->orderBy('id','desc');


        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_target_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.target.grid', compact('filter','grid'));
        }

    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->target);

        $edit->link("/backend/targets","Lista Target", "TR")->back();


        $edit->add('qty_visits','Cant Medicos', 'text')->rule('required|max:3');
        $edit->add('active','Vigente', 'checkbox');//->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit) {
            //  $form->model->password = md5(Input::get('password'));
            //  $edit->model->save();
            //print_r($edit->model);die();
            Log::info('New Target Updated, Zona: '.$edit->model->id);
            $edit->message("El registro se guardo correctamente.");
          //  $edit->link("/targets","Regresar");
        });


        return view('backend.target.modify', compact('edit'));
    }

}
