<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create(['name' => 'Libya', 'location' => DB::raw("(ST_GeomFromText('POINT(29.242499 18.601839)'))")]);
        Branch::create(['name' => 'Tunisia', 'location' => DB::raw("(ST_GeomFromText('POINT(32.468397 9.553697)'))")]);
        Branch::create(['name' => 'Egypt', 'location' => DB::raw("(ST_GeomFromText('POINT(30.054878 31.220527)'))")]);
    }
}
