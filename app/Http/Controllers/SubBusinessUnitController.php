<?php namespace Reflex\Http\Controllers;

use Reflex\BusinessUnit;
use Reflex\Company;
use Reflex\Http\Requests;

use Reflex\SubBusinessUnit;
use Illuminate\Routing\ResponseFactory;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;

class SubBusinessUnitController extends Controller {
    protected $subBusinessUnit;
    private $responseFactory;

    public function __construct(SubBusinessUnit $subBusinessUnit, ResponseFactory $responseFactory)
    {
        $this->subBusinessUnit = $subBusinessUnit;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subBusinessUnit = $this->subBusinessUnit->newQuery()->with('business_unit','business_unit.company');
        return $subBusinessUnit->get()->toJson();
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
     * @param  Requests\SubBusinessUnitRequest $request
     * @return Response
     */
    public function store(Requests\SubBusinessUnitRequest $request)
    {
        $subBusinessUnit = SubBusinessUnit::create(array('business_unit_id' => $request->input('business_unit_id'),
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ));

        $subBusinessUnit = $this->subBusinessUnit->newQuery()->with('business_unit','business_unit.company')->where('id','=',$subBusinessUnit->id)->first();
        return $this->responseFactory->json($subBusinessUnit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $subBusinessUnit = $this->subBusinessUnit->findOrFail($id);
        return $this->responseFactory->json($subBusinessUnit);
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
        $subBusinessUnit = $this->subBusinessUnit->findOrFail($id);
        $subBusinessUnit->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->subBusinessUnit->findOrFail($id)->delete();
    }

    public function getIndex()
    {

        $filter = DataFilter::source($this->subBusinessUnit->newQuery()->with('business_unit','business_unit.company'));
     //   $filter->add('business_unit.company.name','Empresas', 'select')->options(Company::lists('name', 'id'));
        $filter->add('business_unit.name','Unidad de Negocios', 'text');
        $filter->add('code','Codigo','text');
        $filter->add('code','Codigo','text');
        $filter->add('name','Nombre','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('id','ID', true)->style("width:100px");
        $grid->add('business_unit.company.name','Empresa',false);
        $grid->add('business_unit.name','Unidad de Negocio',false);
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',true);
        // $grid->add('active','Activo',true);

        $grid->edit('sub_unidad_de_negocios/edit', 'Editar','modify|delete');
        $grid->link('sub_unidad_de_negocios/edit',"Nueva Sub Unidad", "TR");
        $grid->orderBy('name','asc');

        $grid->buildCSV('exportar_sub_unidad_de_negocios', 'Y-m-d.His');
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

        return  view('sub_business_unit.grid', compact('filter','grid'));
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->subBusinessUnit);

        $edit->label('Editar Unidad de Negocios');
        $edit->link("/sub_unidad_de_negocios","Lista Unidades de Negocios", "TR")->back();
        $edit->add('business_unit.name','Empresa', 'select')->options(BusinessUnit::with('company')->lists('name','id'));
        $edit->add('code','Codigo', 'text')->rule('required|max:5');
        $edit->add('name','Nombre', 'text')->rule('required|max:25');

        $edit->add('description','Descripción', 'redactor');

        $edit->saved(function () use ($edit) {
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/sub_unidad_de_negocios","Regresar");
        });


        return view('sub_business_unit.modify', compact('edit'));
    }
}
