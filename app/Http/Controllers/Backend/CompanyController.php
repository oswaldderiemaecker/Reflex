<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Reflex\Models\Company;
use Reflex\Models\Country;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Routing\ResponseFactory;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;

class CompanyController extends Controller {

    protected $company;
    private $responseFactory;

    public function __construct(Company $company, ResponseFactory $responseFactory)
    {
        $this->company = $company;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $companies = $this->company->newQuery()->with('country');
        return $companies->get()->toJson();
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
	 * @param Requests\CompanyRequest $request
	 * @return Response
	 */
	public function store(Requests\CompanyRequest $request)
	{
        $company = Company::create(array('country_id' => $request->input('country_id'),
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ));


        $company = $this->company->newQuery()->with('country')->where('id','=',$company->id)->first();
        return $this->responseFactory->json($company);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $company = $this->company->findOrFail($id);
        return $this->responseFactory->json($company);
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
     * @param  Request $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $company = $this->company->findOrFail($id);
        $company->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->company->findOrFail($id)->delete();
	}

    public function getIndex()
    {
        $filter = DataFilter::source($this->company->newQuery()->with('country'));
        $filter->add('country.name','Paises', 'select')->options(Country::lists('name', 'id'));
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('id','ID', true)->style("width:100px");
        $grid->add('country.name','Paises',false);
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',true);

        $grid->edit('/backend/empresas/edit', 'Editar','modify|delete');
        $grid->link('/backend/empresas/edit',"Nueva Empresa", "TR");
        $grid->orderBy('name','desc');

        $grid->row(function ($row) {
            if ($row->cell('id')->value == 20) {
                $row->style("background-color:#CCFF66");
            } elseif ($row->cell('id')->value > 15) {
                $row->cell('title')->style("font-weight:bold");
                $row->style("color:#f00");
            }
        });

        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_empresas_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.company.grid', compact('filter','grid'));
        }
    }

    public function anyEdit()
    {
        $edit = DataEdit::source($this->company);

        //$edit->label('Editar Empresa');
        $edit->link("/backend/empresas","Lista Empresas", "TR")->back();
        $edit->add('country.name','Empresa', 'select')->options(Country::lists('name', 'id'));
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');

        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/empresas","Regresar");
        });

        return view('backend.company.modify', compact('edit'));
    }
}