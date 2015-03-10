<?php namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests;

use Illuminate\Routing\ResponseFactory;

class CompanyController extends Controller {

    protected $company;
    private $responseFactory;

    public function __construct(Company $company, ResponseFactory $responseFactory)
    {
        $this->company = $company;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $companies = $this->company->newQuery()->with('country');
        return $companies->get()->toJson();
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
	 * @param Requests\CompanyRequest $request
	 * @return Response
	 */
	public function store(Requests\CompanyRequest $request)
	{
        $company = Company::create(array('country_id' => $request->input('country_id'),
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ));


        $company = $this->company->newQuery()->with('country')->where('id','=',$company->id)->first();
        return $this->responseFactory->json($company);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $company = $this->company->findOrFail($id);
        return $this->responseFactory->json($company);
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
     * @param  Request $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $company = $this->company->findOrFail($id);
        $company->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->company->findOrFail($id)->delete();
	}

}
