<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SqlFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path1 = public_path('../database/seeders/sql/CreateTables_vn_units.sql');
        $sql1 = file_get_contents($path1);
        $path2 = public_path('../database/seeders/sql/ImportData_vn_units.sql');
        $sql2 = file_get_contents($path2);
        DB::unprepared($sql1);
        DB::unprepared($sql2);
    }
}
