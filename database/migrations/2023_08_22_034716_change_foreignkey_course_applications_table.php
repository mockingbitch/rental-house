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
        Schema::table('course_applications', function(Blueprint $table) {
            $table->dropForeign('schedule_applications_schedule_id_foreign');
            $table->renameColumn('schedule_id', 'course_id');
            $table->foreign('course_id')
                ->references('id')  
                ->on('lesson_courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_applications', function(Blueprint $table) {
            $table->dropForeign('course_applications_course_id_foreign');
            $table->renameColumn('schedule_id', 'course_id');
            $table->foreign('schedule_id')
                ->references('id')  
                ->on('lesson_courses')
                ->onDelete('cascade');
        });
    }
};
