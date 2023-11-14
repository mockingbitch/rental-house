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
        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('house_id');
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('floor')->nullable();
            $table->text('images')->nullable();
            $table->double('price');
            $table->integer('capacity');
            $table->integer('status')
                ->default(0)
                ->comment('0: Unavailable; 1: Available; 2: Rented');
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
        Schema::dropIfExists('rooms');
    }
};
