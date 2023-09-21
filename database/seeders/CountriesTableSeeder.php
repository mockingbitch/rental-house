<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('countries')->truncate();

        $countries = [
            ['日本', 'Japan', 'Nhật Bản'],
            ['ベトナム', 'Vietnam', 'Việt Nam'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name_jp' => $country[0],
                'name_en' => $country[1],
                'name_vn' => $country[2],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
