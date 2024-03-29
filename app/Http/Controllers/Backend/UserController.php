<?php namespace Reflex\Http\Controllers\Backend;

use Auth;
use Hash;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Input;
use Log;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Company;
use Reflex\Models\Role;
use Reflex\Models\SubBusinessUnit;
use Reflex\User;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataForm\DataForm;
use Zofe\Rapyd\DataGrid\DataGrid;

class UserController extends Controller {

    protected $user;
    protected $responseFactory;

    public function __construct(User $user, ResponseFactory $responseFactory)
    {
        $this->user = $user;
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

        $imei = $request->get('imei', null, true);

        $users = $this->user->newQuery()->with('role','company','business_unit','sub_business_unit');

        if (!(is_null($imei) || $imei == '')) {
            $users->where('imei', '=', $imei);
            if($users->get()->count() > 0){
                return $users->get()->first()->toJson();
            }else{
                return $this->responseFactory->make(array());
            }

        }
        return $users->get()->toJson();
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
     * @param  int $id
     * @return Response
     */
	public function update(Request $request, $id)
	{
        $user = User::with('role','company','business_unit','sub_business_unit')->find($id);

        if($request->hasFile('photo')){

            $user->photo = $user->id.'_'.$request->file('photo')->getFilename();
            $request->file('photo')->move(public_path().'/uploads/user', $user->photo);
            $user->save();
        }

        return $user->toJson();
	}


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function upload(Request $request, $id)
    {
        $user = User::with('role','company','business_unit','sub_business_unit')->find($id);

              if($request->hasFile('photo')) {
                  $photo = $request->file('photo');
                  $user->photo = $user->id . '_' .$photo->getClientOriginalName();
                  $photo->move(public_path() . '/uploads/user', $user->photo);
                  $user->save();
              }else{
                  return $this->responseFactory->json('empty');
              }

        return $user->toJson();
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
        $filter = DataFilter::source($this->user
            ->newQuery()
            ->with('role','company','business_unit','sub_business_unit','parent'));

        $filter->add('role.name','Rol', 'text');
        $filter->add('sub_business_unit.name','Sub Unidad de Negocio', 'text');
        $filter->add('code','Codigo', 'text');
        $filter->add('firstname','Nombres','text');
        $filter->add('lastname','Apellidos','text');
        $filter->submit('Buscar');
        $filter->reset('Limpiar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('role.name','Role', false);
        $grid->add('sub_business_unit.name','Sub Unidad', false);
        $grid->add('code','Codigo',true);
        $grid->add('{{ $firstname." ".$lastname }}','Nombres',false);
        $grid->add('lastname','Nombres',false);
        $grid->add('email','Correo',false);
        $grid->add('username','Correo',false);

        $grid->edit('/backend/usuarios/edit', 'Editar','modify|delete');
        $grid->link('/backend/usuarios/edit',"Nuevo Usuario", "TR");
        $grid->orderBy('code','desc');


        $grid->row(function ($row) {
            $row->cell('code')->style("background-color:#CCFF66");

        });


        if(isset($_GET['export']))
        {
            return $grid->buildCSV('exportar_usuarios_', 'Y-m-d.His');

        } else {
            $grid->paginate(25);
            return view('backend.user.grid', compact('filter','grid'));
        }

    }

    public function anyEdit()
    {
        $edit = DataEdit::source($this->user);
        $password = $edit->model->password;

        $edit->link("/backend/usuarios","Lista Usuarios", "TR")->back();

        $company = new Company();
        $companies = $company->newQuery()->where('id','=',Auth::user()->company_id)->get();
        $company_combo = array();

        foreach($companies as $companie)
        {
            $company_combo[$companie->id] = $companie->name;
        }

        $edit->add('role_id','Rol','select')->options(Role::lists('name', 'id')->toArray());
        $edit->add('company_id','Empresa','select')->options($company_combo)->rule('required');
        $edit->add('sub_business_unit_id','Sub Unidad de Negocio', 'autocomplete')->options(SubBusinessUnit::lists('name', 'id')->toArray())->rule('required');
        $edit->add('code','Código', 'text')->rule('required|max:6');
        $edit->add('firstname','Nombres', 'text')->rule('required|max:50');
        $edit->add('lastname','Apellidos', 'text')->rule('required|max:50');
        $edit->add('closeup_name','Nombre en Closeup', 'text')->rule('required|max:50');
        $edit->add('email','Correo Electrónico', 'text')->rule('required|max:50');
        $edit->add('username','Usuario', 'text')->rule('required|max:50');
        $edit->add('password','Contraseña', 'password');
        $edit->add('photo','Foto', 'image')->move('uploads/user/')->fit(240, 160)->preview(120,80);

        $edit->add('imei', 'Imei', 'text')->rule('max:50');
        // $edit->add('active','Vigente', 'select')->options(array(1 => 'SI',0 => 'NO'));

        $edit->saved(function () use ($edit,$password) {

            if(Input::get('password') != '')
            {
                $edit->model->password = Hash::make(Input::get('password'));
                $edit->model->save();
            }else{
                $edit->model->password = $password;
                $edit->model->save();

            }

            Log::info('New Campaign Created or Updated, Ciclo: '.$edit->model->code);
            $edit->message("El registro se guardo correctamente.");
            $edit->link("/backend/usuarios","Regresar");
        });

        return view('backend.user.modify', compact('edit'));
    }

    public function anyForm()
    {
        $edit_user = Auth::user();
        $password = $edit_user->password;

        $form = DataForm::source($edit_user);

        $form->add('code','Código', 'text')->rule('required|max:6');
        $form->add('firstname','Nombres', 'text')->rule('required|max:50');
        $form->add('lastname','Apellidos', 'text')->rule('required|max:50');
        $form->add('closeup_name','Nombre en Closeup', 'text')->rule('required|max:50');
        $form->add('email','Correo Electrónico', 'text')->rule('required|max:50');
        $form->add('username','Usuario', 'text')->rule('required|max:50');
        $form->add('password','Contraseña', 'password');
        $form->add('photo','Foto', 'image')->move('uploads/user/')->fit(240, 160)->preview(120,80);

        // $edit->add('active','Vigente', 'select')->options(array(1 => 'SI',0 => 'NO'));

        $form->submit('Actualizar');

        $form->saved(function () use ($form,$password) {
            if(Input::get('password') != '')
            {
                $form->model->password = Hash::make(Input::get('password'));
                $form->model->save();
            }else{
                $form->model->password = $password;
                $form->model->save();

            }
        });

        return view('backend.user.form', compact('form'));

    }

}
