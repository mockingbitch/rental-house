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
        Schema::create('kids', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('parent_id');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nick_name', 50)->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->integer('age');
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
        Schema::dropIfExists('kids');
    }
};
