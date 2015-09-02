<?php namespace Reflex\Http\Controllers\Backend;

use Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Log;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Category;
use Reflex\Models\Client;
use Reflex\Models\ClientType;
use Reflex\Models\Company;
use Reflex\Models\Hobby;
use Reflex\Models\Location;
use Reflex\Models\Place;
use Reflex\Models\Specialty;
use Reflex\Models\University;
use Reflex\Models\Zone;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;

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
     * @param Request $request
     * @return Response
     */
	public function index(Request $request)
	{
        $zone_id       = $request->get('zone_id',null,true);
        $active        = $request->get('active',null,true);
        $query_in      = $request->get('query',null,true);

        $clients       = $this->client->newQuery()->with('category','place','hobby','university','location',
            'client_type','specialty_base','specialty_target');

        if(!(is_null($zone_id) || $zone_id == '')){
            $clients->where('zone_id', '=', $zone_id);
        }

        if(!(is_null($query_in) || $query_in == '')){
            $clients->where('closeup_name','LIKE','%'.strtoupper($query_in).'%');

        }

        if(!(is_null($active) || $active == '')){
            $clients->where('active','=', ($active=='1')?true:false);
        }

        return $clients->get()->toJson();
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
     * @param Request $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $latitude  = $request->get('latitude', null, true);
        $longitude = $request->get('longitude', null, true);
        $qty_patiences = $request->get('qty_patiences', null, true);
        $price_inquiry = $request->get('price_inquiry', null, true);
        $social_level_patients = $request->get('social_level_patients', null, true);

        $attends_child = $request->get('attends_child', null, true);
        $attends_teen = $request->get('attends_teen', null, true);
        $attends_adult = $request->get('attends_adult', null, true);
        $attends_old = $request->get('attends_old', null, true);


        $client = Client::with('category','place','hobby','university','location',
            'client_type','specialty_base','specialty_target')->find($id);

        if(!(is_null($latitude) || $latitude == '')){
            $client->latitude = $latitude;
        }

        if(!(is_null($longitude) || $longitude == '')){
            $client->longitude = $longitude;
        }

        if(!(is_null($qty_patiences) || $qty_patiences == '')) {
            $client->qty_patiences = $qty_patiences;
        }


            if(!(is_null($attends_child) || $attends_child == '' || $attends_child == '0')){
                $client->attends_child = true;
            }else{
                $client->attends_child = false;
            }

            if(!(is_null($attends_teen) || $attends_teen == '' || $attends_teen == '0')){
                $client->attends_teen = true;
            }else{
                $client->attends_teen = false;
            }

            if(!(is_null($attends_adult) || $attends_adult == '' || $attends_adult == '0')){
                $client->attends_adult = true;
            }else{
                $client->attends_adult = false;
            }

            if(!(is_null($attends_old) || $attends_old == '' || $attends_old == '0')){
                $client->attends_old = true;
            }else{
                $client->attends_old = false;
            }


        if(!(is_null($price_inquiry) || $price_inquiry == '')){
            $client->price_inquiry = $price_inquiry;
        }

        if(!(is_null($social_level_patients) || $social_level_patients == '')){
            $client->social_level_patients = $social_level_patients;
        }


        $client->save();
        return $this->responseFactory->json($client);
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
        ini_set('memory_limit','10024M');

        $filter = DataFilter::source($this->client->newQuery()->with('client_type','zone','category','place',
            'specialty_base','specialty_target','location')->where('client_type_id', '=',1)->take(1000));
        $filter->add('client_type.name','Tipo', 'select')->options(ClientType::lists('name', 'id')->toArray());
        $filter->add('zone.name','Zona', 'autocomplete')->options(Zone::lists('name', 'id')->toArray());
        $filter->add('firstname','Nombres','text');
        $filter->add('lastname','Apellidos','text');
       // $filter->add('institution','Institución','text');
        $filter->add('address','Dirección','text');
      //  $filter->add('gender','Genero', 'select')->options(array('M' => 'Masculino','F' => 'Femenino'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('client_type.code','Tipo', false);
        $grid->add('zone.name','Zona', false);
        $grid->add('code','Codigo',true);
        $grid->add('firstname','Nombre',true);
        $grid->add('lastname','Apellido',true);
       // $grid->add('institution','Institución',true);
        $grid->add('address','Dirección',true);
        $grid->add('location.name','Distrito',false);
        $grid->add('category.code','Cat',false);
        $grid->add('place.code','Tar',false);
        $grid->add('specialty_base.code','Es B',false);
        $grid->add('specialty_target.code','Es T',false);

        $grid->edit('/backend/clientes/edit', 'Editar','modify|delete');
        $grid->link('/backend/clientes/edit',"Nuevo Cliente", "TR");

        $grid->row(function ($row) {
            $row->cell('firstname')->style("background-color:#CCFF66");
            $row->cell('lastname')->style("background-color:#CCFF66");
        });

        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_clientes_', 'Y-m-d.His');

        } else {
            $grid->paginate(35);
            return  view('backend.client.grid', compact('filter','grid'));
        }
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->client);

        $edit->link("/backend/clientes","Lista Clientes", "TR")->back();

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

        $edit->add('client_type_id','Tipo','select')->options(ClientType::lists('name', 'id')->toArray());
        $edit->add('company_id','Empresa','select')->options($company_combo)->rule('required');
        $edit->add('zone.name','Zona','autocomplete')->options($zones_combo)->rule('required');
        $edit->add('category_id','Categoria','select')->options(Category::lists('name', 'id')->toArray());
        $edit->add('place_id','Tarea','select')->options(Place::lists('name', 'id')->toArray());
        $edit->add('hobby_id','Hobby','select')->options(Hobby::lists('name', 'id')->toArray());
        $edit->add('specialty_base_id','Esp. Base','select')->options(Specialty::lists('name', 'id')->toArray());
        $edit->add('specialty_target_id','Esp. Target','select')->options(Specialty::lists('name', 'id')->toArray());
        $edit->add('university_id','Universidad','select')->options(University::lists('name', 'id')->toArray());
        $edit->add('location_id','Localidad','autocomplete')->options(Location::lists('name', 'id')->toArray())
                                                            ->rule('required');
        $edit->add('code','Codigo', 'text')->rule('required|max:15');
        //$edit->add('name','Nombres Completo', 'text')->rule('required|max:5');
        $edit->add('firstname','Nombres', 'text')->rule('required|max:50');
        $edit->add('lastname','Apellido', 'text')->rule('required|max:50');
        $edit->add('photo','Foto', 'image')->move('uploads/doctor/')->fit(240, 160)->preview(120,80);
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
        $edit->add('social_level_patients','Nivel Socio-Economico Pacientes', 'select')->options(array('C' => 'C',
            'B' => 'B','A' => 'A'));

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
            $edit->link("/backend/clientes","Regresar");
        });

        return view('backend.client.modify', compact('edit'));
    }
}
