<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Reflex\Models\Category;
use Reflex\Models\Company;
use Auth;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataFilter;
use Zofe\Rapyd\Facades\DataGrid;

class CategoryController extends Controller {

    protected $category;
    private   $responseFactory;

    public function __construct(Category $category, ResponseFactory $responseFactory)
    {
        $this->category = $category;
        $this->responseFactory = $responseFactory;
    }
	/**
	 * Display a listing of the resource.
	 * @param Request $request
     *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $company_id = $request->get('company_id',null,true);

        $categories = $this->category->newQuery()->with('company');

        if(!(is_null($company_id) || $company_id == '')){
            $categories->where('company_id','=', $company_id);
        }

        return $categories->get()->toJson();
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
	 * @param Request $request
     *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $company_id  = $request->get('company_id',null,true);
        $code        = $request->get('code',null,true);
        $name        = $request->get('name',null,true);
        $qty_visits  = $request->get('qty_visits',null,true);
        $description = $request->get('description',null,true);
        $active      = $request->get('active',null,true);

        $category = Category::create(array('company_id' => $company_id,
            'code' => $code, 'name' => $name, 'qty_visits' => $qty_visits,
            'description' => $description,'active' => $active
        ));

        return $this->responseFactory->json($category);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $category = $this->category->findOrFail($id);
        return $this->responseFactory->json($category);
	}

	/**
	 * Show the form for editing the specified resource.
	 *

	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

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
        $qty_visits  = $request->get('qty_visits',null,true);
        $description = $request->get('description',null,true);
        $active      = $request->get('active',null,true);

        $category = Category::find($id);
        $category->company_id = $company_id;
        $category->code = $code;
        $category->name = $name;
        $category->qty_visits = $qty_visits;
        $category->description = $description;
        $category->active = $active;

        $category->save();

        return $this->responseFactory->json($category);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->category->findOrFail($id)->delete();
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

        $filter = DataFilter::source($this->category->newQuery()->with('company'));
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
        $grid->add('qty_visits','# de Visitas',true);
        $grid->add('description','Descripción',true);

        $grid->edit('/backend/categorias/edit', 'Editar','modify|delete');
        $grid->link('/backend/categorias/edit',"Nueva Categoría", "TR");
        $grid->orderBy('name','asc');

        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_categorias_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.category.grid', compact('filter','grid'));
        }
    }

    public function anyEdit()
    {
        $edit = DataEdit::source($this->category);

        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->link("/backend/categorias","Lista tareas", "TR")->back();
        $edit->add('company.name','Empresa', 'select')->options($company_combo);
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');
        $edit->add('qty_visits','# de Visitas', 'text')->rule('required|max:25');
        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/categorias","Regresar");
        });

        return view('backend.category.modify', compact('edit'));
    }
}
