<?php namespace Reflex\Http\Controllers;

use Illuminate\Routing\ResponseFactory;
use Reflex\BusinessUnit;
use Reflex\Campaign;
use Reflex\Company;
use Reflex\Http\Requests;
use Reflex\Region;
use Reflex\Target;
use Auth;
use Log;
use Reflex\Zone;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class TargetController extends Controller {

    protected $target;
    protected $responseFactory;

    public function __construct(Target $target, ResponseFactory $responseFactory)
    {
        $this->target = $target;
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

        $filter = DataFilter::source($this->target->newQuery()->with('company','campaign','zone','user','client'));

       //s $filter->add('company.name','Empresa', 'text');
        $filter->add('campaign.name','Ciclo', 'select')->options(Campaign::lists('name', 'id'));
        $filter->add('zone.name','Zona', 'autocomplete')->options(Zone::lists('name', 'id'));
        $filter->add('user.firstname','Nombre','text');
        $filter->add('user.lastname','Apellido','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        //$grid->add('company.name','Empresa',false);
        $grid->add('campaign.name','Ciclo',false);
        $grid->add('zone.name','Zona',false);
        $grid->add('{{ $user->firstname." ".$user->lastname." - ".$user->role->code }}','Usuario',false);
        $grid->add('{{ $client->firstname." ".$client->lastname." - ".$client->client_type->code }}','Cliente',false);
        $grid->add('qty_visits','Cant. Visitas',true);

        //$grid->edit('targets/edit', 'Mostrar','show');
        //$grid->link('targets/edit',"Nueva Zona", "TR");
        $grid->orderBy('id','desc');

        //$grid->buildCSV();
        $grid->paginate(25);
/*
        $grid->row(function ($row) {
            $row->cell('')->style("background-color:#CCFF66");

        });*/



        return  view('target.grid', compact('filter','grid'));
    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->target->with('zone','campaign','company'));

        $edit->label('Editar Zona');
        $edit->link("/zonas","Lista Zonas", "TR")->back();

        $businessUnit = new BusinessUnit();
        $business_units = $businessUnit->newQuery()->where('company_id','=',Auth::user()->company_id)->get();
        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $business_units_combo = array('' => 'Seleccionar');
        $company_combo = array('' => 'Seleccionar');
        foreach($business_units as $business_unit)
        {
            $business_units_combo[$business_unit->id] = $business_unit->name;
        }

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->add('company.name','Empresa','text');
        $edit->add('campaign.name','Ciclo','text');
        $edit->add('zone.name','Zona','text');
        $edit->add('zone.closeup_name','Usuario','text');
        $edit->add('{{ $client->lastname }}','Cliente','text');
        $edit->add('qty_visits','Cant Medicos', 'text')->rule('required|max:3');
        $edit->add('active','Vigente', 'checkbox');//->options(array(1 => 'SI',0 => 'NO'));


        return view('target.modify', compact('edit'));
    }

}
