<?php namespace Reflex\Http\Controllers\Backend;


use Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Log;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\BusinessUnit;
use Reflex\Models\Company;
use Reflex\Models\Zone;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;

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
        $zones = $this->zone->newQuery()->with('company','regions','business_unit');
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
        $businessUnit = new BusinessUnit();
        $business_units = $businessUnit->newQuery()->where('company_id','=',Auth::user()->company_id)->get();

        $business_units_combo = array('' => 'Selecciona Unidad de Negocio');

        foreach($business_units as $business_unite)
        {
            $business_units_combo[$business_unite->id] = $business_unite->name.' .';
        }

        $filter = DataFilter::source($this->zone->newQuery()->with('sub_business_unit', 'regions', 'locations', 'specialties', 'assignments'));

       // $filter->add('company.name','Empresa', 'text');
        $filter->add('sub_business_unit.name','Sub Unidad de Negocio', 'autocomplete');//->options($business_units_combo);
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
       // $filter->add('zone_type','Tipo', 'select')->options(array('S' => 'Capital','N' => 'Provincia'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('code','Cod.',true)->style("width:100px");
        $grid->add('name','Nombre',true)->style("width:150px");
        $grid->add('sub_business_unit.name','Sub U. de Negocio',false)->style("width:150px");
        $grid->add('{{ $locations->count() }}','Localidades');
        //$grid->add('{{ implode(", ", $regions->lists("name")) }}','Regiones');
        $grid->add('{{ $assignments->count() }}', 'Asignaciones');
        $grid->add('{{ $specialties->count() }}','Esp. Target');

        $grid->edit('/backend/zonas/edit', 'Editar','modify|delete');
        $grid->link('/backend/zonas/edit',"Nueva Zona", "TR");
       // $grid->orderBy('name','desc');



        $grid->row(function ($row) {
            $row->cell('name')->style("background-color:#CCFF66");
        });


        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_zonas_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.zone.grid', compact('filter','grid'));
        }
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->zone);

        $edit->link("/backend/zonas","Lista Zonas", "TR")->back();

        $businessUnit = new BusinessUnit();
        $business_units = $businessUnit->newQuery()->where('company_id','=',Auth::user()->company_id)->get();
        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $business_units_combo = array('' => 'Seleccionar');
        foreach($business_units as $business_unit)
        {
            $business_units_combo[$business_unit->id] = $business_unit->name;
        }

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->add('company.name','Empresa','select')->options($company_combo)->rule('required');

       // $edit->add('business_unit.name','Unidad de Negocios','select')->options($business_units_combo)->rule('required');

        $edit->add('sub_business_unit.name','Sub Unidad de Negocios','autocomplete');//->options($business_units_combo)->rule('required');

        //  $edit->add('regions','Regiones','select')->options(Region::lists('name', 'id'));
       // $edit->add('regions.name','Regiones','tags',true);//->options(Region::lists('name', 'id'));
        $edit->add('locations.district', 'Localidades','tags',true);

        //   $edit->add('users.closeup_name','Usuarios','tags',false);

        $edit->add('specialties.realname', 'Especialidades Target', 'tags');

        $edit->add('code','Codigo', 'text')->rule('required|max:10');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');
      //  $edit->add('hidden_name','Nombre Proximo', 'text');
        $edit->add('description','Descripción', 'textarea');
       /* $edit->add('qty_doctors','Cant Medicos', 'text')->rule('required|max:3')->insertValue(1);
        $edit->add('qty_contacts_am','Contactos AM', 'text')->rule('required|digits_between:1,3')->insertValue(1);
        $edit->add('qty_contacts_pm','Contactos PM', 'text')->rule('required|digits_between:1,3')->insertValue(1);
        $edit->add('qty_contacts_vip','Contactos VIP', 'text')->rule('required|digits_between:1,3')->insertValue(1);
        $edit->add('qty_available_days','Dias Habiles', 'text')->rule('required|digits_between:1,3')->insertValue(1);*/
        $edit->add('zone_type','Tipo', 'select')->options(array('S' => 'Capital','N' => 'Provincia'));
        $edit->add('vacancy','Vacante', 'checkbox');
        $edit->add('active','Vigente', 'checkbox');//->options(array(1 => 'SI',0 => 'NO'));

       /* $edit->saved(function () use ($edit) {
            Log::info('New Zone Created or Updated, Zona: '.$edit->model->name);
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/zonas","Regresar");
        });*/

        return view('backend.zone.modify', compact('edit'));
    }

}
