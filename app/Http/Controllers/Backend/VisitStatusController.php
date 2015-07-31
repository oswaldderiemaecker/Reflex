<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Reflex\Models\VisitStatus;

class VisitStatusController extends Controller {

	protected $visit_status;
	protected $responseFactory;

	public function __construct(VisitStatus $visit_status, ResponseFactory $responseFactory)
	{
		$this->visit_status = $visit_status;
		$this->responseFactory = $responseFactory;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $visit_statuses = $this->visit_status->all();
        return $this->responseFactory->json($visit_statuses);
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
