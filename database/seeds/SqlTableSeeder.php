<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class SqlTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::raw("delete from user_zone;
insert into user_zone
select id, id+2 from zones;

delete from region_zone;
insert into region_zone
select c.zone_id, r.id from clients as c inner join locations as l on l.id = c.location_id inner join regions as r on r.id = l.region_id group by c.zone_id, r.id;

delete from location_zone;
insert into location_zone
select zone_id, location_id from clients group by zone_id,location_id;

delete from targets;

insert into targets (company_id,campaign_id, zone_id, user_id,client_id,qty_visits,created_at,updated_at,deleted_at)
select 1,1,uz.zone_id,uz.user_id,c.id,c.qty_visits,now(),now(),null from user_zone as uz
inner join clients as c on uz.zone_id = c.zone_id;
");





    }

}