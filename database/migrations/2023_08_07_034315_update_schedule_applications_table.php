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
            $table->enum('status', [0, 1])
                ->default(0)
                ->after('learner_question')
                ->comment('0: Not payment; 1: Payment successed');
            
            $table->string('payment_intent_id', 100)
                ->after('learner_question');
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
            $table->dropColumn('status');
            
            $table->dropColumn('payment_intent_id');
        });
    }
};
