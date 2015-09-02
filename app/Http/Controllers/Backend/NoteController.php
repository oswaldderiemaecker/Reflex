<?php namespace Reflex\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Note;
use Reflex\Models\NoteType;
use Uuid;

class NoteController extends Controller {

    protected $note;
    protected $responseFactory;

    public function __construct(Note $note, ResponseFactory $responseFactory)
    {
        $this->note = $note;
        $this->responseFactory = $responseFactory;
    }

	/**
	 * Display a listing of the resource.
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
        $client_id    = $request->get('client_id',null,true);
        $zone_id      = $request->get('zone_id',null,true);
        $user_id      = $request->get('user_id',null,true);
        $campaign_id  = $request->get('campaign_id',null,true);
        $note_type_id = $request->get('note_type_id',null,true);
        $pagination   = $request->get('pagination',null,true);

        $page = 5;
        $data =  Note::with('note_type','target','client');

        if(!(is_null($client_id) || $client_id == '')){
            $data->where('client_id','=', $client_id);
        }

        if(!(is_null($zone_id) || $zone_id == '')){
            $data->where('zone_id','=', $zone_id);
        }

        if(!(is_null($user_id) || $user_id == '')){
            $data->where('user_id','=', $user_id);
        }

        if(!(is_null($campaign_id) || $campaign_id == '')){
            $data->where('campaign_id','=', $campaign_id);
        }

        if(!(is_null($note_type_id) || $note_type_id == '')){
            $data->where('note_type_id','=', $note_type_id);
        }

        $data->whereNull('deleted_at');

        $data->orderBy('date','desc');

        if($pagination == 'true'){
            $data = $data->paginate($page);
        }else{
            $data = $data->get();
        }

        return $this->responseFactory->json($data);
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
     * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $client_id      = $request->get('client_id',null,true);
        $zone_id        = $request->get('zone_id',null,true);
        $assignment_id = $request->get('assignment_id', null, true);
        $user_id        = $request->get('user_id',null,true);
        $campaign_id    = $request->get('campaign_id',null,true);
        $note_type_id   = $request->get('note_type_id',null,true);
        $target_id      = $request->get('target_id',null,true);

        $date           = $request->get('date',null,true);
        $time           = $request->get('time',null,true);
        $title          = $request->get('title',null,true);
        $description    = $request->get('description',null,true);
        $is_from_mobile = $request->get('is_from_mobile',null,true);

        $noteType = NoteType::where('id', '=', $note_type_id)->first();
        /*	echo Carbon::createFromFormat('d/m/Y',Input::get('date'));
            die();*/

        $uuid = Uuid::generate();

        $note = Note::create(array(
            'uuid' => $uuid,
            'note_type_id' => $note_type_id,
            'assignment_id' => $assignment_id,
            'zone_id' => $zone_id,
            'user_id' => $user_id,
            'campaign_id' => $campaign_id,
            'target_id' => $target_id,
            'client_id' => $client_id,
            'date' => Carbon::createFromFormat('d/m/Y',$date)->toDateTimeString(),
            'time' => $time,
            'title' => $title,
            'description' => $description,
            'is_completed' => (($noteType->code == 'INF' || $noteType->code == 'NOT')?true:false),
            'is_from_mobile' => $is_from_mobile
        ));

        $noteResponse = Note::with('note_type','client')->find($uuid);

        return $this->responseFactory->json($noteResponse);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $note = $this->note->newQuery()->with('note_type','client')->find($id);
        return $this->responseFactory->json($note);
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
        $this->note->findOrFail($id)->delete();
        return $this->responseFactory->json("OK");
	}
}
