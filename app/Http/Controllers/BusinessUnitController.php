<?php namespace Reflex\Http\Controllers;

use Illuminate\Http\Request;
use Reflex\BusinessUnit;
use Reflex\Company;
use Reflex\Http\Requests;
use Illuminate\Contracts\Routing\ResponseFactory;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;


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

        $filter = DataFilter::source($this->businessUnit->newQuery()->with('company'));
        $filter->add('company.name','Empresas', 'select')->options(Company::lists('name', 'id'));
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        //$grid = DataGrid::source($this->country);


        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('id','ID', false);
        $grid->add('company.name','Empresa',false);
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',true);
        // $grid->add('active','Activo',true);

        $grid->edit('unidad_de_negocios/edit', 'Editar','modify|delete');
        $grid->link('unidad_de_negocios/edit',"Nueva Unidad de Negocios", "TR");
        $grid->orderBy('name','asc');

        $grid->buildCSV('exportar_empresas', 'Y-m-d.His');
        $grid->paginate(25);
/*
        $grid->row(function ($row) {
            if ($row->cell('id')->value == 20) {
                $row->style("background-color:#CCFF66");
            } elseif ($row->cell('id')->value > 15) {
                $row->cell('name')->style("font-weight:bold");
                $row->style("color:#f00");
            }
        });*/

        return  view('business_unit.grid', compact('filter','grid'));
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->businessUnit);

        $edit->label('Editar Unidad de Negocios');
        $edit->link("/unidad_de_negocios","Lista Unidades de Negocios", "TR")->back();
        $edit->add('company.name','Empresa', 'select')->options(Company::lists('name', 'id'));
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');

        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/unidad_de_negocios","Regresar");
        });


        return view('business_unit.modify', compact('edit'));
    }

}
