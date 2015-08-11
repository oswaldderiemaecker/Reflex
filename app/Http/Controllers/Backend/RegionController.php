<?php namespace Reflex\Http\Controllers\Backend;

use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Region;

class RegionController extends Controller {


    protected $region;
    protected $responseFactory;

    public function __construct(Region $region, ResponseFactory $responseFactory)
    {
        $this->region = $region;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$country_id = $request->get('country_id',null,true);

        $regions = $this->region->newQuery()->with('country');

		if(!(is_null($country_id) || $country_id == '')){
			$regions->where('country_id','=', $country_id);
		}
        return $regions->get()->toJson();
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
