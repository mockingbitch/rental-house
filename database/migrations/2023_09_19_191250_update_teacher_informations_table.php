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
            $table->string('stripe_account_id', 70)->nullable()->after('birthday');
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
            $table->dropColumn('stripe_account_id');
        });
    }
};
