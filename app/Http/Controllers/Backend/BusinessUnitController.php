<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Reflex\Models\BusinessUnit;
use Reflex\Models\Company;
use Reflex\Http\Requests;
use Illuminate\Contracts\Routing\ResponseFactory;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Reflex\Http\Controllers\Controller;


class BusinessUnitController extends Controller {

    protected $businessUnit;
    private $responseFactory;

    public function __construct(BusinessUnit $businessUnit, ResponseFactory $responseFactory)
    {
        $this->businessUnit = $businessUnit;
        $this->responseFactory = $responseFactory;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $company_id = $request->get('company_id',null,true);

        $businessUnits = $this->businessUnit->newQuery()->with('company');

        if(!(is_null($company_id) || $company_id == '')){
            $businessUnits->where('company_id','=', $company_id);
        }


        return $businessUnits->get()->toJson();
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
     * @param  Requests\BusinessUnitRequest $request
	 * @return Response
	 */
	public function store(Requests\BusinessUnitRequest $request)
	{
        $businessUnit = BusinessUnit::create(array('company_id' => $request->input('company_id'),
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ));

        $businessUnit = $this->businessUnit->newQuery()->with('company')->where('id','=',$businessUnit->id)->first();
        return $this->responseFactory->json($businessUnit);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $businessUnit = $this->businessUnit->findOrFail($id);
        return $this->responseFactory->json($businessUnit);
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
        $businessUnit = $this->businessUnit->findOrFail($id);
        $businessUnit->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->businessUnit->findOrFail($id)->delete();
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

        $filter = DataFilter::source($this->businessUnit->newQuery()->with('company'));
        $filter->add('company.name','Empresas', 'select')->options($company_combo);
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        //$grid = DataGrid::source($this->country);


        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('company.name','Empresa',false);
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',true);

        $grid->edit('/backend/unidad_de_negocios/edit', 'Editar','modify|delete');
        $grid->link('/backend/unidad_de_negocios/edit',"Nueva Unidad de Negocios", "TR");
        $grid->orderBy('name','asc');

        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_unidades_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.business_unit.grid', compact('filter','grid'));
        }
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->businessUnit);

        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->link("/backend/unidad_de_negocios","Lista Unidades de Negocios", "TR")->back();
        $edit->add('company.name','Empresa', 'select')->options($company_combo);
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');

        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/unidad_de_negocios","Regresar");
        });


        return view('backend.business_unit.modify', compact('edit'));
    }

}
