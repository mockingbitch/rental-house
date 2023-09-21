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
        Schema::table('users', function (Blueprint $table) {
            ///verify_teacher: 0 - common-user, 
            $table->tinyInteger('verify_teacher')
                ->after('role')
                ->default(0)
                ->comment('0 - Common user; 1 - Verifying; 2 - Verifed, become teacher; 3 - Denied.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('verify_teacher');
        });
    }
};
