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
        DB::statement("ALTER TABLE lessons 
        MODIFY COLUMN 
        status ENUM('0', '1', '2', '3', '4', '5') 
        DEFAULT '1'
	    comment '0: Inactive; 1: Active; 2: Draft; 3: Pending; 4: Sendback; 5: Rejected'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE lessons 
        MODIFY COLUMN 
        status ENUM('0', '1', '2') 
        DEFAULT '1'
	    comment '0: Inactive; 1: Active; 2: Draft'");
    }
};
