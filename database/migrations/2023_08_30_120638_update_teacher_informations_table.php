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
        Schema::table('teacher_informations', function (Blueprint $table) {
            $table->integer('country_id')->nullable()->after('country_code');
            $table->integer('city_id')->nullable()->after('country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_informations', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('city_id');
        });
    }
};
