<?php namespace Reflex\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Campaign;
use Reflex\Company;
use Reflex\Http\Requests;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Auth;
use Log;

class CampaignController extends Controller {

    protected $campaign;
    protected $responseFactory;

    public function __construct(Campaign $campaign, ResponseFactory $responseFactory)
    {
        $this->campaign = $campaign;
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
        $filter = DataFilter::source($this->campaign->newQuery()->with('company'));
        $filter->add('code','Codigo', 'text');
        $filter->add('name','Nombre','text');
        $filter->add('start_date','Inicio de Ciclo','date');
        $filter->add('active','Vigente','select')->options(array(1 => 'Ciclo Activo',0 => 'Ciclos Inactivos'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('company.name','Empresa', false);
        $grid->add('code','Codigo',true);
        $grid->add('name','Nombre',false);
        $grid->add('start_date','Inicio de Ciclo',true);
        $grid->add('finish_date','Cierre de Ciclo',true);
        $grid->add('{{ ($active == 1)?"SI":"NO"}}','Vigente',false);

        $grid->edit('ciclos/edit', 'Editar','modify|delete');
        $grid->link('ciclos/edit',"Nuevo Ciclo", "TR");
        $grid->orderBy('name','desc');

        $grid->buildCSV('exportar_ciclos', 'Y-m-d.His');
        $grid->paginate(12);


        $grid->row(function ($row) {
            $row->cell('name')->style("background-color:#CCFF66");

        });

        //$grid->build();

        return  view('campaign.grid', compact('filter','grid'));
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->campaign);

        $edit->label('Editar Ciclo');
        $edit->link("/ciclos","Lista Ciclos", "TR")->back();


        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $company_combo = array();

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->add('company_id','Empresa','select')->options($company_combo)->rule('required');
        $edit->add('code','Codigo', 'text')->rule('required|max:6');
        $edit->add('name','Nombre', 'text')->rule('required|max:50');
        $edit->add('description','Descripción', 'text');

        $edit->add('start_date','Inicio Ciclo','date')->format('d/m/Y', 'es');
        $edit->add('close_date','Cierre Ciclo','date')->format('d/m/Y', 'es');
        $edit->add('finish_date','Termino Ciclo','date')->format('d/m/Y', 'es');



        $edit->add('qty_days','Cant. dias habiles', 'select')->rule('digits_between:1,3')
            ->options(array('20' => '20' ,'21' => '21','22' => '22'));


       // $edit->add('active','Vigente', 'select')->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit) {
            //  $form->model->password = md5(Input::get('password'));
            //  $edit->model->save();
            //print_r($edit->model);die();
            Log::info('New Campaign Created or Updated, Ciclo: '.$edit->model->code);
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/ciclos","Regresar");
        });

        return view('campaign.modify', compact('edit'));
    }

}
