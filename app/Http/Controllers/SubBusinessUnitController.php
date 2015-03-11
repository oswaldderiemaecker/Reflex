<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\SubBusinessUnit;
use Illuminate\Routing\ResponseFactory;

class SubBusinessUnitController extends Controller {
    protected $subBusinessUnit;
    private $responseFactory;

    public function __construct(SubBusinessUnit $subBusinessUnit, ResponseFactory $responseFactory)
    {
        $this->subBusinessUnit = $subBusinessUnit;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subBusinessUnit = $this->subBusinessUnit->newQuery()->with('business_unit','business_unit.company');
        return $subBusinessUnit->get()->toJson();
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
     * @param  Requests\SubBusinessUnitRequest $request
     * @return Response
     */
    public function store(Requests\SubBusinessUnitRequest $request)
    {
        $subBusinessUnit = SubBusinessUnit::create(array('business_unit_id' => $request->input('business_unit_id'),
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ));

        $subBusinessUnit = $this->subBusinessUnit->newQuery()->with('business_unit','business_unit.company')->where('id','=',$subBusinessUnit->id)->first();
        return $this->responseFactory->json($subBusinessUnit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $subBusinessUnit = $this->subBusinessUnit->findOrFail($id);
        return $this->responseFactory->json($subBusinessUnit);
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
        $subBusinessUnit = $this->$subBusinessUnit->findOrFail($id);
        $subBusinessUnit->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->$subBusinessUnit->findOrFail($id)->delete();
    }

}
