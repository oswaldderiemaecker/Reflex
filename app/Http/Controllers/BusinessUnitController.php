<?php namespace App\Http\Controllers;

use App\BusinessUnit;
use App\Http\Requests;
use Illuminate\Contracts\Routing\ResponseFactory;


class BusinessUnitController extends Controller {

    protected $businessUnit;
    private $responseFactory;

    public function __construct(BusinessUnit $businessUnit, ResponseFactory $responseFactory)
    {
        $this->businessUnit = $businessUnit;
        $this->responseFactory = $responseFactory;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $businessUnits = $this->businessUnit->newQuery()->with('company');
        return $businessUnits->get()->toJson();
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
     * @param  Requests\BusinessUnitRequest $request
	 * @return Response
	 */
	public function store(Requests\BusinessUnitRequest $request)
	{
        $businessUnit = BusinessUnit::create(array('company_id' => $request->input('company_id'),
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ));

        $businessUnit = $this->businessUnit->newQuery()->with('company')->where('id','=',$businessUnit->id)->first();
        return $this->responseFactory->json($businessUnit);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $businessUnit = $this->businessUnit->findOrFail($id);
        return $this->responseFactory->json($businessUnit);
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $businessUnit = $this->businessUnit->findOrFail($id);
        $businessUnit->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->businessUnit->findOrFail($id)->delete();
	}

}
