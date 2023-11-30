<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->string('province_code');
            $table->string('district_code');
            $table->string('ward_code');
            $table->dropColumn('ward_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn('province_code');
            $table->dropColumn('district_code');
            $table->dropColumn('ward_code');
            $table->integer('ward_id');
        });
    }
};
