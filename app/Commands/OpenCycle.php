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

        ini_set('memory_limit','10024M');
        Eloquent::unguard();

        DB::disableQueryLog();

        echo("starting Proccess Kardex Job\n\n");

        $time_start = Carbon::now();

        Log::info("start at: ".$time_start->toDateTimeString()."\n");

        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        /*DB::table('user_zone')->truncate();
        DB::table('region_zone')->truncate();
        DB::table('location_zone')->truncate();
        DB::table('visits')->delete();
        DB::table('routes')->delete();
        DB::table('notes')->delete();
        DB::table('targets')->delete();*/

        DB::statement("insert into user_zone(zone_id, user_id) select id as zone_id, (id+2) as user_id from zones;");

        DB::statement("insert into region_zone(zone_id, region_id) ".
            "select c.zone_id as zone_id, r.id as region_id from clients as c ".
            "inner join locations as l on l.id = c.location_id ".
            "inner join regions as r on r.id = l.region_id group by c.zone_id, r.id;");

        DB::statement("insert into location_zone(zone_id, location_id) ".
            "select zone_id, location_id from clients group by zone_id,location_id;");

        DB::statement("insert into targets(company_id,campaign_id, zone_id, user_id,client_id,qty_visits,created_at, updated_at, deleted_at) ".
            "select 1 as company_id, 1 as campaign_id, uz.zone_id,uz.user_id,c.id as client_id,1 as qty_visits, now() as created_at, now() as updated_at, null as deleted_at from user_zone as uz ".
            " inner join clients as c on uz.zone_id = c.zone_id;");

        Log::info(Uuid::generate());

        $time_start = Carbon::now();

        Log::info("finish at: ".$time_start->toDateTimeString()."\n");

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
                $visit->user_id = $target->user_id;
                $visit->campaign_id = $target->campaign_id;
                $visit->target_id = $target->id;
                $visit->client_id = $target->client_id;
                $visit->active = $num;

                $visit->save();
            }
        }

        $this->delete();
    }

}
