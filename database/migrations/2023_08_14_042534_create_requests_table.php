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
        Schema::create('requests', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->string('summary', 200);
            $table->text('detail');
            $table->float('min_price');
            $table->float('max_price');
            $table->string('about_teacher', 200);
            $table->string('language', 100);
            $table->integer('min_time');
            $table->integer('max_time');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->string('weekdays', 20);
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
        Schema::dropIfExists('requests');
    }
};
