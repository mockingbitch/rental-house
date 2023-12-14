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
        Schema::create('houses', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('lessor_id');
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->integer('ward_id')->nullable();
            $table->string('address')->nullable();
            $table->string('verified_at')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('status')
                ->default(0)
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
        Schema::dropIfExists('houses');
    }
};
