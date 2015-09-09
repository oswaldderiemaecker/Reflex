<?php namespace Reflex\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Reflex\Http\Controllers\Controller;
use Reflex\Http\Requests;
use Reflex\Models\Schedule;
use Uuid;

class ScheduleController extends Controller {

    protected $schedule;
    private $responseFactory;

    public function __construct(Schedule $schedule, ResponseFactory $responseFactory)
    {
        $this->schedule = $schedule;
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
        $client_id = $request->get('client_id',null,true);
        $zone_id   = $request->get('zone_id',null,true);

        $schedules = $this->schedule->newQuery();

        if(!(is_null($client_id) || $client_id == 0)){
            $schedules->where('client_id','=', $client_id);
        }

        if(!(is_null($zone_id) || $zone_id == 0)){
            $schedules->where('zone_id','=', $zone_id);
        }

        return $schedules->get()->toJson();
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
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $client_id   = $request->get('client_id',null,true);
        $day         = $request->get('day',null,true);
        $start_time  = $request->get('start_time',null,true);
        $finish_time = $request->get('finish_time',null,true);
        $zone_id     = $request->get('zone_id',null,true);

        Schedule::where('client_id', '=',  $client_id)
            ->where('day','=', $day)->delete();

        $schedule = Schedule::create(array('uuid' => Uuid::generate(),
            'zone_id' => $zone_id,
            'client_id' => $client_id,
            'day' => $day,
            'start_time' => $start_time,
            'finish_time' => $finish_time
        ));

        return $this->responseFactory->json($schedule);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $schedule = $this->schedule->findOrFail($id);
        return $this->responseFactory->json($schedule);
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param Request $request
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request, $id)
	{
        $client_id   = $request->get('client_id',null,true);
        $day         = $request->get('day',null,true);
        $start_time  = $request->get('start_time',null,true);
        $finish_time = $request->get('finish_time',null,true);
        $zone_id     = $request->get('zone_id',null,true);

        $schedule = Schedule::find($id);
        $schedule->zone_id = $zone_id;
        $schedule->client_id = $client_id;
        $schedule->day = $day;
        $schedule->start_time = $start_time;
        $schedule->finish_time = $finish_time;
        $schedule->save();

        return $this->responseFactory->json($schedule);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->schedule->findOrFail($id)->delete();
	}

    public function calendar($id)
    {
        $result = null;
        $schedules = Schedule::with('client','client.location')
            ->where('client_id', '=',$id)->get();

        foreach($schedules as $data)
        {

            $result[] = array
            (
                'id' => $data->uuid,
                'title' => $data->client->address.' '.$data->client->location->name,
                'start' => Carbon::now()
                    ->startOfWeek()
                    ->addDays($data->day-1)
                    ->hour(explode(':', $data->start_time)[0])
                    ->minute(explode(':', $data->start_time)[1])->toDateTimeString(),
                'end' => Carbon::now()
                    ->startOfWeek()
                    ->addDays($data->day-1)
                    ->hour(explode(':', $data->finish_time)[0])
                    ->minute(explode(':', $data->finish_time)[1])->toDateTimeString(),
                'color' => '#3CB371',
                'allDay' => false

            );
        }
        return $this->responseFactory->json($result);
    }

}
