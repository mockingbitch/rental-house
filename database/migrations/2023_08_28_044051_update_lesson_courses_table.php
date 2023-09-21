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
        Schema::table('lesson_courses', function (Blueprint $table) {
            $table->string('title')->after('lesson_id');
            $table->string('deadline')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_courses', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('deadline');
        });
    }
};
