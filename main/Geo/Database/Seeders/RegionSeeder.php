<?php

namespace Main\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run()
    {
        DB::unprepared(file_get_contents(__DIR__.'/sqls/geo_regions.sql'));
    }
}
