<?php

namespace Main\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{
    public function run()
    {
        DB::unprepared(file_get_contents(__DIR__.'/sqls/auth_branches.sql'));
    }
}
