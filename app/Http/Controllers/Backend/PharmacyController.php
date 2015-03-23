<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Models\Category;
use Reflex\Models\Client;
use Reflex\Models\Company;
use Reflex\Http\Requests;
use Reflex\Models\Location;
use Reflex\Models\Place;
use Reflex\Models\Zone;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Reflex\Http\Controllers\Controller;
use Auth;
use Log;
class PharmacyController extends Controller {

    protected $client;
    protected $responseFactory;

    public function __construct(Client $client, ResponseFactory $responseFactory)
    {
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }
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

    public function getIndex()
    {
        ini_set('memory_limit','1024M');

        $filter = DataFilter::source($this->client->newQuery()->with('client_type','zone','category','place','specialty_base','specialty_target','location')->whereIn('client_type_id', array(2))->take(1000));
        $filter->add('zone.name','Zona', 'autocomplete')->options(Zone::lists('name', 'id'));
        $filter->add('code','Codigo','text');
        $filter->add('name','Nombre','text');
        $filter->add('address','Dirección','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('zone.name','Zona', false);
        $grid->add('code','Codigo',true);
        $grid->add('client_type.name','Tipo',false);
        $grid->add('name','Institución',false);
        $grid->add('address','Dirección',true);
        $grid->add('location.name','Distrito',false);

        $grid->edit('/backend/farmacias/edit', 'Editar','modify|delete');
        $grid->link('/backend/farmacias/edit',"Nueva Farmacias", "TR");
        $grid->orderBy('name','asc');

        $grid->buildCSV('exportar_farmacias', 'Y-m-d.His');
        $grid->paginate(35);

        $grid->row(function ($row) {
            $row->cell('name')->style("background-color:#CCFF66");

        });


        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_farmacias_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.pharmacy.grid', compact('filter','grid'));
        }
    }

    public function anyEdit()
    {
        $edit = DataEdit::source($this->client);

        $edit->link("/backend/farmacias","Lista Farmacias", "TR")->back();

        $zone = new Zone();
        $zones = $zone->newQuery()->where('company_id','=',Auth::user()->company_id)->get();

        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $zones_combo = array('' => 'Seleccionar');
        $company_combo = array();

        foreach($zones as $zona)
        {
            $zones_combo[$zona->id] = $zona->name;
        }

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->add('client_type_id','Tipo','select')->options(array('2' => 'Farmacia'));
        $edit->add('company_id','Empresa','select')->options($company_combo)->rule('required');
        $edit->add('zone_id','Zona','select')->options($zones_combo)->rule('required');
        $edit->add('category_id','Categoria','select')->options(Category::lists('name', 'id'));
        $edit->add('place_id','Tarea','select')->options(Place::lists('name', 'id'));
        $edit->add('location_id','Localidad','autocomplete')->options(Location::lists('name', 'id'))->rule('required');
        $edit->add('code','Codigo', 'text')->rule('required|max:15');
        $edit->add('name','Nombres', 'text')->rule('required|max:50');
        $edit->add('firstname','Nombre Contacto', 'text')->rule('required|max:50');
        $edit->add('lastname','Apellido Contacto', 'text')->rule('required|max:50');
        //$edit->add('photo','Foto', 'image')->move('uploads/doctor/')->fit(240, 160)->preview(120,80);
        $edit->add('email','Correo', 'text')->rule('max:50');

        $edit->add('qty_visits','Cant. Visitas', 'select')->options(array(1 => '1',2 => '2',3 => '3', 4 => '4'));
        $edit->add('address','Dirección', 'text')->rule('required|max:200');
        $edit->add('reference','Referencia', 'text')->rule('max:150');
        $edit->add('phone','Teléfono', 'text')->rule('max:15');
        $edit->add('mobile','Celular', 'text')->rule('max:15');

        $edit->add('active','Vigente', 'select')->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit) {
        //  $form->model->password = md5(Input::get('password'));
        //  $edit->model->save();
        //print_r($edit->model);die();
        Log::info('New Pharmacy Created or Updated, Zona: '.$edit->model->name);
        $edit->message("El registro se guardo correctamente.");
        $edit->link("/backend/farmacias","Regresar");
    });

        return view('backend.pharmacy.modify', compact('edit'));
    }

}
