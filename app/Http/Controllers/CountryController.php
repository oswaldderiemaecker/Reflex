<?php namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests;
use Illuminate\Routing\ResponseFactory;

class CountryController extends Controller {

    protected $country;
    private $responseFactory;

    public function __construct(Country $country, ResponseFactory $responseFactory)
    {
        $this->country = $country;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $countries = $this->country->all();
        return $this->responseFactory->json($countries);
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
     * @param Requests\CountryRequest $request
	 * @return Response
	 */
	public function store(Requests\CountryRequest $request)
	{
       $country = Country::create(array('code' => $request->input('code'),
            'name' => $request->input('name'),
            'currency' => $request->input('currency'),
            'language' => $request->input('language'),
            'description' => $request->input('description')
        ));
        return response()->json($country);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $country = $this->country->findOrFail($id);
        return $this->responseFactory->json($country);

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
        $country = $this->country->findOrFail($id);
        $country->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->country->findOrFail($id)->delete();
	}

}
