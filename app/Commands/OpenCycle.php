<?php namespace Reflex\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Log;
use Reflex\Models\Target;
use Reflex\Models\Visit;
use Uuid;

class OpenCycle extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        ini_set("memory_limit","-1");

        echo("starting Proccess Kardex Job\n\n");

        $time_start = Carbon::now();

        Log::info("start at: ".$time_start->toDateTimeString()."\n");

        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        DB::table('user_zone')->delete();
        DB::table('region_zone')->delete();
        DB::table('location_zone')->delete();
        DB::table('visits')->where('campaign_id' ,'=', $campaign->id)->delete();
        DB::table('routes')->where('campaign_id' ,'=', $campaign->id)->delete();
        DB::table('notes')->where('campaign_id'  ,'=', $campaign->id)->delete();
        DB::table('targets')->where('campaign_id','=', $campaign->id)->delete();

        DB::statement("insert into user_zone select id, id+2 from zones;");

        DB::statement("insert into region_zone ".
            "select c.zone_id, r.id from clients as c ".
            "inner join locations as l on l.id = c.location_id ".
            "inner join regions as r on r.id = l.region_id group by c.zone_id, r.id;");

        DB::statement("insert into location_zone ".
            "select zone_id, location_id from clients group by zone_id,location_id;");

        DB::statement("insert into targets (company_id,campaign_id, zone_id, user_id,client_id,qty_visits) ".
            "select 1,1,uz.zone_id,uz.user_id,c.id,c.qty_visits from user_zone as uz ".
            "inner join clients as c on uz.zone_id = c.zone_id;");

        Log::info(Uuid::generate());

        $time_start = Carbon::now();

        Log::info("finish at: ".$time_start->toDateTimeString()."\n");

        $this->delete();

        $targets = Target::where('campaign_id' ,'=', $campaign->id)->get();

        foreach($targets as $target)
        {
            foreach(range(1,$target->qty_visits) as $num)
            {
                $visit = new Visit();
                $visit->uuid = Uuid::generate();
                $visit->visit_type_id = 1;
                $visit->visit_status_id = 1;
                $visit->zone_id = $target->zone_id;
                $visit->campaign_id = $target->campaign_id;
                $visit->target_id = $target->id;
                $visit->client_id = $target->client_id;
                $visit->active = $num;

                $visit->save();
            }
        }
    }

}
