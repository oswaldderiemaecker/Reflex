<?php namespace Reflex\Http\Controllers;

use GuzzleHttp\Message\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Reflex\Http\Requests;

use Reflex\Zone;

class ZoneController extends Controller {

    protected $zone;
    protected $responseFactory;

    public function __construct(Zone $zone, ResponseFactory $responseFactory)
    {
        $this->zone = $zone;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $zones = $this->zone->newQuery()->with('company','region','business_unit');
        return $zones->get()->toJson();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{


	}

	/**
	 * Store a newly created resource in storage.
     * @param  Requests\ZoneRequest $request
	 * @return Response
	 */
	public function store(Requests\ZoneRequest $request)
	{
        $zone = Zone::create($request->all());

        $zone = $this->zone->newQuery()->with('company','region','business_unit')->where('id','=',$zone->id)->first();
        return $this->responseFactory->json($zone);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $zone = $this->zone->findOrFail($id);
        return $this->responseFactory->json($zone);
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
     * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $zone = $this->zone->findOrFail($id);
        $zone->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->zone->findOrFail($id)->delete();
	}

}
