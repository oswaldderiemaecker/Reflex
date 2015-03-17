<?php namespace Reflex\Http\Controllers;

use GuzzleHttp\Message\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\BusinessUnit;
use Reflex\Company;
use Reflex\Http\Requests;

use Reflex\Region;
use Reflex\Zone;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Auth;
use Log;
class ZoneController extends Controller {

    protected $zone;
    protected $responseFactory;

    public function __construct(Zone $zone, ResponseFactory $responseFactory)
    {
        $this->zone = $zone;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $zones = $this->zone->newQuery()->with('company','region','business_unit');
        return $zones->get()->toJson();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{


	}

	/**
	 * Store a newly created resource in storage.
     * @param  Requests\ZoneRequest $request
	 * @return Response
	 */
	public function store(Requests\ZoneRequest $request)
	{
        $zone = Zone::create($request->all());

        $zone = $this->zone->newQuery()->with('company','region','business_unit')->where('id','=',$zone->id)->first();
        return $this->responseFactory->json($zone);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $zone = $this->zone->findOrFail($id);
        return $this->responseFactory->json($zone);
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
     * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $zone = $this->zone->findOrFail($id);
        $zone->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->zone->findOrFail($id)->delete();
	}

    public function getIndex()
    {

        $filter = DataFilter::source($this->zone->newQuery()->with('company','business_unit','regions','locations','users'));
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->add('zone_type','Tipo', 'select')->options(array('S' => 'Capital','N' => 'Provincia'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        //$grid = DataGrid::source($this->country);


        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

       // $grid->add('id','ID', false);

        $grid->add('code','Cod.',true);
        $grid->add('name','Nombre',true);
        $grid->add('business_unit.name','U. de Negocio',false);
        $grid->add('company.name','Empresa',false);
        $grid->add('{{ implode(", ", $locations->lists("name")) }}','Localidades');
        $grid->add('{{ implode(", ", $regions->lists("name")) }}','Regiones');
        $grid->add('{{ $users->count() }}','Usuarios');

        $grid->edit('zonas/edit', 'Editar','modify|delete');
        $grid->link('zonas/edit',"Nueva Zona", "TR");
        //$grid->orderBy('name','desc');

        $grid->buildCSV();
        $grid->paginate(25);

        $grid->row(function ($row) {
            $row->cell('name')->style("background-color:#CCFF66");

        });



        return  view('zone.grid', compact('filter','grid'));
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->zone);

        $edit->label('Editar Zona');
        $edit->link("/zonas","Lista Zonas", "TR")->back();

        $businessUnit = new BusinessUnit();
        $business_units = $businessUnit->newQuery()->where('company_id','=',Auth::user()->company_id)->get();
        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $business_units_combo = array('' => 'Seleccionar');
        $company_combo = array('' => 'Seleccionar');
        foreach($business_units as $business_unit)
        {
            $business_units_combo[$business_unit->id] = $business_unit->name;
        }

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->add('company.name','Empresa','select')->options($company_combo)->rule('required');
        $edit->add('business_unit.name','Unidad de Negocios','select')->options($business_units_combo)->rule('required');

        $edit->add('regions','Regiones','checkboxgroup')->options(Region::lists('name', 'id'));
        $edit->add('locations.district', 'Localidades','tags',true);
        $edit->add('users.closeup_name','Usuarios','tags',false);

        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');
        $edit->add('hidden_name','Nombre Proximo', 'text');
        $edit->add('description','Descripción', 'textarea');
        $edit->add('qty_doctors','Cant Medicos', 'text')->rule('required|max:3');
        $edit->add('qty_contacts_am','Contactos AM', 'text')->rule('required|digits_between:1,3');
        $edit->add('qty_contacts_pm','Contactos PM', 'text')->rule('required|digits_between:1,3');
        $edit->add('qty_contacts_vip','Contactos VIP', 'text')->rule('required|digits_between:1,3');
        $edit->add('qty_available_days','Dias Habiles', 'text')->rule('required|digits_between:1,3');
        $edit->add('zone_type','Tipo', 'select')->options(array('S' => 'Capital','N' => 'Provincia'));
        $edit->add('vacancy','Vacante', 'checkbox');
        $edit->add('active','Vigente', 'checkbox');//->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit) {
          //  $form->model->password = md5(Input::get('password'));
          //  $edit->model->save();
            //print_r($edit->model);die();
            Log::info('New Zone Created or Updated, Zona: '.$edit->model->name);
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/zonas","Regresar");
        });

        return view('zone.modify', compact('edit'));
    }

}
