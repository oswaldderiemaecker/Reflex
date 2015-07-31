<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Reflex\Http\Controllers\Controller;
use Reflex\Models\Country;
use Reflex\Http\Requests;
use Illuminate\Routing\ResponseFactory;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;

class CountryController extends Controller {

    protected $country;
    private $responseFactory;

    public function __construct(Country $country, ResponseFactory $responseFactory)
    {
        $this->country = $country;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $countries = $this->country->all();
        return $this->responseFactory->json($countries);
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
     * @param Requests\CountryRequest $request
	 * @return Response
	 */
	public function store(Requests\CountryRequest $request)
	{
       $country = Country::create(array('code' => $request->input('code'),
            'name' => $request->input('name'),
            'currency' => $request->input('currency'),
            'language' => $request->input('language'),
            'description' => $request->input('description')
        ));
        return response()->json($country);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $country = $this->country->findOrFail($id);
        return $this->responseFactory->json($country);

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
        $country = $this->country->findOrFail($id);
        $country->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->country->findOrFail($id)->delete();
	}

    public function getIndex()
    {

        $filter = DataFilter::source($this->country);
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        //$grid = DataGrid::source($this->country);


        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

       // $grid->add('id','ID', true)->style("width:100px");
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',true);
        $grid->add('currency','Moneda',true);
        $grid->add('language','Lenguaje',true);
       // $grid->add('active','Activo',true);

        $grid->edit('/backend/paises/edit', 'Editar','modify');
        $grid->link('/backend/paises/edit',"Nuevo País", "TR");
        $grid->orderBy('name','asc');

        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_paises_', 'Y-m-d.His');
        } else {
            $grid->paginate(25);
            return  view('backend.country.grid', compact('filter','grid'));
        }
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->country);

        //$edit->label('Editar Pais');
        $edit->link("/backend/paises","Lista Paises", "TR")->back();
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');
        $edit->add('language','Idioma', 'text')->rule('required|max:25');
        $edit->add('currency','Moneda', 'text')->rule('required|max:25');

        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/paises","Regresar");
        });


        return view('backend.country.modify', compact('edit'));
    }

}
