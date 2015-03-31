<?php namespace Reflex\Http\Controllers\Frontend;

use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\User;
use Zofe\Rapyd\DataForm\DataForm;
use Reflex\Http\Controllers\Controller;
use Auth;
use Log;
use Hash;
use Input;

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
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = $this->user->newQuery()->with('role','company','business_unit','sub_business_unit');
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

        return view('frontend.user.form', compact('form'));

    }

}
