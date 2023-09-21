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
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('short_video_for_parent_thumbnail');
            $table->dropColumn('short_video_for_learner_thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('short_video_for_parent_thumbnail')->nullable()->after('short_video_for_parent');
            $table->string('short_video_for_learner_thumbnail')->nullable()->after('short_video_for_learner');
        });
    }
};
