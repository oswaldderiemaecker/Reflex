<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Routing\ResponseFactory;
use Reflex\Http\Requests;
use Reflex\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Reflex\Models\Reason;

class ReasonController extends Controller {

	protected $reason;
	protected $responseFactory;

	public function __construct(Reason $reason, ResponseFactory $responseFactory)
	{
		$this->reason = $reason;
		$this->responseFactory = $responseFactory;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $reasons = $this->reason->all();
        return $this->responseFactory->json($reasons);
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
