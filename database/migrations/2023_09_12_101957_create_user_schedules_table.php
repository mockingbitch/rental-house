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
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('schedule_id');
            $table->foreign('schedule_id')
                ->references('id')
                ->on('course_schedules')
                ->onDelete('cascade');
            $table->enum('status', [0, 1])
                ->default(1)
                ->comment('0: Skip; 1: Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_schedules');
    }
};
