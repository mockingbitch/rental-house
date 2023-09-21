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
        //
        Schema::table('schedule_applications', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('schedule_applications', function (Blueprint $table) {
            $table->enum('status', [0, 1])
                ->default(1)
                ->after('learner_question')
                ->comment('0: Not payment; 1: Payment successed');
        });
    }
};
