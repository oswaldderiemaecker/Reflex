<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Reflex\Models\VisitType;

class VisitTypeController extends Controller {

	protected $visit_type;
	protected $responseFactory;

	public function __construct(VisitType $visit_type, ResponseFactory $responseFactory)
	{
		$this->visit_type = $visit_type;
		$this->responseFactory = $responseFactory;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$visit_types = $this->visit_type->all();
		return $this->responseFactory->json($visit_types);
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

}
