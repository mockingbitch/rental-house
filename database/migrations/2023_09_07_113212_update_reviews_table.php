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
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('ease_of_understanding')->nullable()->after('rate');
            $table->integer('beneficial')->nullable()->after('ease_of_understanding');
            $table->integer('good_at_teacher')->nullable()->after('beneficial');
            $table->integer('enjoyable')->nullable()->after('good_at_teacher');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('ease_of_understanding');
            $table->dropColumn('beneficial');
            $table->dropColumn('good_at_teacher');
            $table->dropColumn('enjoyable');
        });
    }
};
