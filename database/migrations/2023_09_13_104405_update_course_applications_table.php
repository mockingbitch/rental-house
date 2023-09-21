<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE course_applications 
        MODIFY COLUMN 
        status ENUM('0', '1', '2') 
        DEFAULT '1'
	    comment '0: Not payment; 1: Payment successed; 2: Cancel'");
        Schema::table('course_applications', function (Blueprint $table) {
            $table->text('cancel_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE course_applications 
        MODIFY COLUMN 
        status ENUM('0', '1') 
        DEFAULT '1'
	    comment '0: Not payment; 1: Payment successed'");
        Schema::table('course_applications', function (Blueprint $table) {
            $table->dropColumn('cancel_reason');
        });
    }
};
