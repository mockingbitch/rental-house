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
        Schema::table('kids', function (Blueprint $table) {
            $table->string('name', 100)->after('nick_name');
            $table->date('birthday')->nullable()->after('name');
            $table->string('learning_style')->nullable()->after('birthday');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('age');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kids', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('birthday');
            $table->dropColumn('learning_style');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->integer('age');
        });

    }
};
