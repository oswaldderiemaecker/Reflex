<?php namespace Reflex\Http\Controllers;

use Illuminate\Routing\ResponseFactory;
use Reflex\BusinessUnit;
use Reflex\Campaign;
use Reflex\Category;
use Reflex\Company;
use Reflex\Http\Requests;
use Reflex\Place;
use Reflex\Region;
use Reflex\Target;
use Auth;
use Log;
use Reflex\User;
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
        $filter->add('user.name','Usuario', 'autocomplete')->options(User::lists('closeup_name', 'id'));
        $filter->add('user.firstname','Nombre','text');
        $filter->add('user.lastname','Apellido','text');
        //$filter->add('client.category_id','Categoria','select')->options(Category::lists('name', 'id'));
        //$filter->add('client.place_id','Tarea','select')->options(Place::lists('name', 'id'));
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        //$grid->add('company.name','Empresa',false);
        $grid->add('campaign.name','Ciclo',false);
        $grid->add('zone.name','Zona',false);
        $grid->add('{{ $user->firstname." ".$user->lastname }}','Usuario',false);
        $grid->add('{{ $client->firstname." ".$client->lastname." - ".$client->client_type->code }}','Cliente',false);
        $grid->add('client.category.code','Cat',false);
        $grid->add('client.place.code','Tar',false);
        $grid->add('qty_visits','# Vis',true);

        $grid->edit('targets/edit', 'Mostrar','modify');
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
        $edit = DataEdit::source($this->target);

        $edit->label('Editar Target');
        $edit->link("/targets","Lista Target", "TR")->back();


        $edit->add('qty_visits','Cant Medicos', 'text')->rule('required|max:3');
        $edit->add('active','Vigente', 'checkbox');//->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit) {
            //  $form->model->password = md5(Input::get('password'));
            //  $edit->model->save();
            //print_r($edit->model);die();
            Log::info('New Target Updated, Zona: '.$edit->model->id);
            $edit->message("El registro se guardo correctamente.");
          //  $edit->link("/targets","Regresar");
        });


        return view('target.modify', compact('edit'));
    }

}
