<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Reflex\Models\Company;
use Reflex\Models\Place;
use Auth;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataGrid;

class PlaceController extends Controller {

    protected $place;
    private $responseFactory;

    public function __construct(Place $place, ResponseFactory $responseFactory)
    {
        $this->place = $place;
        $this->responseFactory = $responseFactory;
    }
	/**
	 * Display a listing of the resource.
	 *
     * @param Request $request
	 * @return Response
	 */
	public function index(Request  $request)
	{
        $company_id = $request->get('company_id',null,true);

        $places = $this->place->newQuery()->with('company');

        if(!(is_null($company_id) || $company_id == '')){
            $places->where('company_id','=', $company_id);
        }

        return $places->get()->toJson();
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
        $company_id  = $request->get('company_id',null,true);
        $code        = $request->get('code',null,true);
        $name        = $request->get('name',null,true);
        $description = $request->get('description',null,true);
        $active      = $request->get('active',null,true);

        $place = Place::create(array('company_id' => $company_id,
            'code' => $code, 'name' => $name,
            'description' => $description,'active' => $active
        ));

        return $this->responseFactory->json($place);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $place = $this->place->findOrFail($id);
        return $this->responseFactory->json($place);
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
        $company_id  = $request->get('company_id',null,true);
        $code        = $request->get('code',null,true);
        $name        = $request->get('name',null,true);
        $description = $request->get('description',null,true);
        $active      = $request->get('active',null,true);

        $place = Place::find($id);
        $place->company_id = $company_id;
        $place->code = $code;
        $place->name = $name;
        $place->description = $description;
        $place->active = $active;

        $place->save();

        return $this->responseFactory->json($place);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->place->findOrFail($id)->delete();
	}


    public function getIndex()
    {
        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $company_combo = array('' => 'Seleccionar');

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $filter = DataFilter::source($this->place->newQuery()->with('company'));
        $filter->add('company.name','Empresas', 'select')->options($company_combo);
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('company.name','Empresa',false);
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',true);
        $grid->add('description','Descripción',true);

        $grid->edit('/backend/tareas/edit', 'Editar','modify|delete');
        $grid->link('/backend/tareas/edit',"Nueva Tarea", "TR");
        $grid->orderBy('name','asc');

        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_tareas_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.place.grid', compact('filter','grid'));
        }
    }

    public function anyEdit()
    {
        $edit = DataEdit::source($this->place);

        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->link("/backend/tareas","Lista tareas", "TR")->back();
        $edit->add('company.name','Empresa', 'select')->options($company_combo);
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');
        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/tareas","Regresar");
        });

        return view('backend.place.modify', compact('edit'));
    }

}
