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
        Schema::create('application_details', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('application_id');
            $table->foreign('application_id')
                ->references('id')
                ->on('schedule_applications')
                ->onDelete('cascade');
            $table->integer('kid_id');
            $table->foreign('kid_id')
                ->references('id')
                ->on('kids')
                ->onDelete('cascade');
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
        Schema::dropIfExists('application_details');
    }
};
