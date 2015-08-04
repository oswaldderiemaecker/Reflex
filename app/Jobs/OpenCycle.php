<?php

namespace Reflex\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Log;
use Reflex\Models\Target;
use Reflex\Models\Visit;
use Uuid;

class OpenCycle extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $company_id;

    /**
     * @param $company_id
     */
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit','10024M');
        DB::disableQueryLog();

        echo("starting Proccess Kardex Job\n\n");
        echo("$this->company_id\n");

        $time_start = Carbon::now();

        Log::info("start at: ".$time_start->toDateTimeString()."\n");

        $campaign = DB::table('campaigns')->where('active','=',1)->first();

        DB::table('region_zone')->truncate();
        DB::table('location_zone')->truncate();
        DB::table('visits')->delete();
        DB::table('routes')->delete();
        DB::table('notes')->delete();
        DB::table('targets')->delete();

        DB::statement("insert into region_zone(zone_id, region_id) ".
            "select c.zone_id as zone_id, r.id as region_id from clients as c ".
            "inner join locations as l on l.id = c.location_id ".
            "inner join regions as r on r.id = l.region_id group by c.zone_id, r.id;");

        DB::statement("insert into location_zone(zone_id, location_id) ".
            "select zone_id, location_id from clients group by zone_id,location_id;");

        DB::statement(" insert into targets(company_id,campaign_id, assignment_id, client_id,qty_visits,created_at, updated_at, deleted_at) " .
            " select 1 , 5, uz.id, c.id ,c.qty_visits, now() , now(), null from assignments as uz " .
            " inner join zones as z on z.id = uz.zone_id " .
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
                $visit->assignment_id = $target->assignment_id;
                $visit->zone_id = $target->assignment->zone_id;
                $visit->user_id = $target->assignment->user_id;
                $visit->campaign_id = $target->campaign_id;
                $visit->target_id = $target->id;
                $visit->client_id = $target->client_id;
                $visit->active = $num;

                $visit->save();
            }
        }

        echo("\nfinishin Proccess Kardex Job\n");

        $this->delete();
    }
}
