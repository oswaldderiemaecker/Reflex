<?php namespace Reflex\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Category;
use Reflex\Client;
use Reflex\ClientType;
use Reflex\Company;
use Reflex\Hobby;
use Reflex\Http\Requests;
use Reflex\Location;
use Reflex\Place;
use Reflex\Specialty;
use Reflex\University;
use Reflex\Zone;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Auth;
use Log;
class ClientController extends Controller {


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

        $filter = DataFilter::source($this->client->newQuery()->with('client_type','zone','category','place','specialty_base','specialty_target','location'));
        $filter->add('client_type.name','Tipo', 'select')->options(ClientType::lists('name', 'id'));
      //  $filter->add('code','Codigo', 'text');
        $filter->add('firstname','Nombres','text');
        $filter->add('lastname','Apellidos','text');
       // $filter->add('institution','Institución','text');
        $filter->add('address','Dirección','text');
      //  $filter->add('gender','Genero', 'select')->options(array('M' => 'Masculino','F' => 'Femenino'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        //$grid = DataGrid::source($this->country);



        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

      //  $grid->add('{{ "<img src=\'uploads/doctor/$photo\'/>" }}','Foto',false);
        // $grid->add('id','ID', false);
        $grid->add('client_type.code','Tipo', false);
        $grid->add('zone.name','Zona', false);
        $grid->add('code','Codigo',true);
        $grid->add('{{ $firstname." ".$lastname }}','Cliente',false);
       // $grid->add('institution','Institución',true);
        $grid->add('address','Dirección',true);
        $grid->add('location.name','Distrito',false);
        $grid->add('category.code','Cat',false);
        $grid->add('place.code','Tar',false);
        $grid->add('specialty_base.code','E. Base',false);
        $grid->add('specialty_target.code','E. Targ',false);

        //$grid->add('gender','Genero',true);
        $grid->edit('clientes/edit', 'Editar','modify|delete');
        $grid->link('clientes/edit',"Nuevo Cliente", "TR");
        //$grid->orderBy('name','desc');

        $grid->buildCSV('exportar_clientes', 'Y-m-d.His');
        $grid->paginate(35);

        $grid->row(function ($row) {
            $row->cell('code')->style("background-color:#CCFF66");

        });

        return  view('client.grid', compact('filter','grid'));
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->client);

        $edit->label('Editar Cliente');
        $edit->link("/clientes","Lista Clientes", "TR")->back();

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

        $edit->add('client_type_id','Tipo','select')->options(ClientType::lists('name', 'id'));
        $edit->add('company_id','Empresa','select')->options($company_combo)->rule('required');
        $edit->add('zone_id','Zona','select')->options($zones_combo)->rule('required');
        $edit->add('category_id','Categoria','select')->options(Category::lists('name', 'id'));
        $edit->add('place_id','Tarea','select')->options(Place::lists('name', 'id'));
        $edit->add('hobby_id','Hobby','select')->options(Hobby::lists('name', 'id'));
        $edit->add('specialty_base_id','Esp. Base','select')->options(Specialty::lists('name', 'id'));
        $edit->add('specialty_target_id','Esp. Target','select')->options(Specialty::lists('name', 'id'));
        $edit->add('university_id','Universidad','select')->options(University::lists('name', 'id'));
        $edit->add('location_id','Localidad','autocomplete')->options(Location::lists('name', 'id'))->rule('required');
        $edit->add('code','Codigo', 'text')->rule('required|max:15');
        //$edit->add('name','Nombres Completo', 'text')->rule('required|max:5');
        $edit->add('firstname','Nombres', 'text')->rule('required|max:50');
        $edit->add('lastname','Apellido', 'text')->rule('required|max:50');
        //$edit->add('photo','Foto', 'image')->move('uploads/doctor/')->fit(240, 160)->preview(120,80);
        $edit->add('email','Correo', 'text')->rule('max:50');
        $edit->add('date_of_birth','Fecha Nac.','date')->format('d/m/Y', 'es');

        $edit->add('gender','Genero', 'select')->options(array('M' => 'Masculino','F' => 'Femenino'));
        $edit->add('qty_visits','Cant. Visitas', 'select')->options(array(1 => '1',2 => '2',3 => '3', 4 => '4'));
        $edit->add('marital_status','Estado Civil', 'select')->options(array('S' => 'Soltero(a)','C' => 'Casado(a)'));
        $edit->add('institution','Institución', 'text')->rule('max:100');
        $edit->add('address','Dirección', 'text')->rule('required|max:200');
        $edit->add('reference','Referencia', 'text')->rule('max:150');
        $edit->add('phone','Teléfono', 'text')->rule('max:15');
        $edit->add('mobile','Celular', 'text')->rule('max:15');

        $edit->add('qty_patiences','Cant. Pacientes Semanal Promedio', 'select')
            ->rule('digits_between:1,3')
            ->options(array('30' => '30 - 50','50' => '50-100','100' => '100-200','200' => '200-mas'));
        $edit->add('price_inquiry','Precio Consulta', 'select')
            ->rule('digits_between:1,10')
            ->options(array('10' => '10 - 20','20' => '20-30','30' => '30-40','40' => '40-50','50' => '50-mas'));
        $edit->add('social_level_patients','Nivel Socio-Economico Pacientes', 'select')->options(array('C' => 'C','B' => 'B','A' => 'A'));

        $edit->add('attends_child','Atiende Niños', 'select')->options(array(1 => 'SI',0 => 'NO'));
        $edit->add('attends_teen','Atiende Jovenes', 'select')->options(array(1 => 'SI',0 => 'NO'));
        $edit->add('attends_adult','Atiende Adultos', 'select')->options(array(1 => 'SI',0 => 'NO'));
        $edit->add('attends_old','Atiende Ancianos', 'select')->options(array(1 => 'SI',0 => 'NO'));
        $edit->add('is_alive','Vivo', 'select')->options(array(1 => 'SI',0 => 'NO'));
        $edit->add('active','Vigente', 'select')->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit) {
            //  $form->model->password = md5(Input::get('password'));
            //  $edit->model->save();
            //print_r($edit->model);die();
            Log::info('New Client Created or Updated, Zona: '.$edit->model->code);
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/clientes","Regresar");
        });

        return view('client.modify', compact('edit'));
    }
}
