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
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('course_id');
            $table->foreign('course_id')
                ->references('id')
                ->on('lesson_courses')
                ->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', [0, 1])
                ->default(1)
                ->comment('0: Inactive; 1: Active');
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
        Schema::dropIfExists('course_schedules');
    }
};
