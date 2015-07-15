<?php namespace Reflex\Http\Controllers\Backend;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Input;
use Log;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Assignment;
use Reflex\Models\Campaign;
use Reflex\Models\Zone;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class AssignmentController extends Controller
{

    protected $assignment;
    protected $responseFactory;

    public function __construct(Assignment $assignment, ResponseFactory $responseFactory)
    {
        $this->assignment = $assignment;
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
        $zone_id = $request->get('zone_id', null, true);
        $user_id = $request->get('user_id', null, true);
        $campaign_id = $request->get('campaign_id', null, true);
        $query_in = $request->get('query', null, true);

        $assignments = $this->assignment->newQuery()->with('zone', 'user', 'campaign');

        if (!(is_null($zone_id) || $zone_id == '')) {
            $assignments->where('zone_id', '=', $zone_id);
        }

        if (!(is_null($user_id) || $user_id == '')) {
            $assignments->where('user_id', '=', $user_id);
        }

        if (!(is_null($campaign_id) || $campaign_id == '')) {
            $assignments->where('campaign_id', '=', $campaign_id);
        }

        if (!(is_null($query_in) || $query_in == '')) {

            $assignments->whereHas('zone', function ($q) use ($query_in) {
                $q->where('name', 'LIKE', '%' . strtoupper($query_in) . '%');
            });
        }

        return $assignments->get()->toJson();
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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function getIndex()
    {

        $filter = DataFilter::source($this->assignment->newQuery()->with('campaign', 'zone', 'user')->take(1000));

        $filter->add('campaign.name', 'Ciclo', 'select')->options(Campaign::lists('name', 'id'));
        $filter->add('zone.name', 'Zona', 'autocomplete')->options(Zone::lists('name', 'id'));
        //$filter->add('user.name','Usuario', 'autocomplete')->options(User::lists('closeup_name', 'id'));
        //$filter->add('user.firstname','Nombre','text');
        $filter->add('user.closeup_name', 'Usuario', 'text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class" => "table table-striped"));

        //$grid->add('company.name','Empresa',false);
        $grid->add('campaign.name', 'Ciclo', false);
        $grid->add('zone.name', 'Zona', false);
        $grid->add('{{ $user->firstname." ".$user->lastname }}', 'Usuario', false);
        $grid->add('description', 'Descripción', true);


        $grid->edit('/backend/asignaciones/edit', 'Mostrar', 'modify');
        //$grid->link('targets/edit',"Nueva Zona", "TR");
        $grid->orderBy('id', 'desc');


        if (isset($_GET['export'])) {
            return $grid->buildCSV('exportar_assignment_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.assignment.grid', compact('filter', 'grid'));
        }

    }


    public function anyEdit()
    {
        $edit = DataEdit::source($this->assignment);

        $edit->link("/backend/asignaciones", "Lista Asignaciones", "TR")->back();


        $edit->add('zone.name', 'Zona', 'autocomplete');//->options($business_units_combo)->rule('required');
        $edit->add('user.closeup_name', 'Usuario', 'autocomplete');//->options($business_units_combo)->rule('required');
        $edit->add('description', 'Descripción', 'redactor');


        $edit->saved(function () use ($edit) {
            //  $form->model->password = md5(Input::get('password'));
            //  $edit->model->save();
            //print_r($edit->model);die();
            Log::info('New Assignment Updated, Zona: ' . $edit->model->id);
            $edit->message("El registro se guardo correctamente.");
            //  $edit->link("/targets","Regresar");
        });


        return view('backend.assignment.modify', compact('edit'));
    }

}
