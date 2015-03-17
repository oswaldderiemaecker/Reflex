<?php namespace Reflex\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Reflex\Http\Requests;
use Reflex\Location;

class LocationController extends Controller {

    protected $location;
    private $responseFactory;

    public function __construct(Location $location, ResponseFactory $responseFactory)
    {
        $this->location = $location;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
     *
     * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
        $country_id = $request->get('country_id',null,true);
        $region_id = $request->get('region_id',null,true);

        $locations = $this->location->newQuery();

        if(!(is_null($country_id) || $country_id == '')){
            $locations->where('country_id','=', $country_id);
        }

        if(!(is_null($region_id) || $region_id == '')){
            $locations->where('region_id','=', $region_id);
        }


        return $locations->get()->toJson();
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
