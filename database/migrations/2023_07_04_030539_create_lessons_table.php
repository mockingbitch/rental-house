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
        Schema::create('lessons', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('title', 255)->nullable();
            $table->integer('teacher_id');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->float('price')->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->integer('target_age_from')->nullable();
            $table->integer('target_age_to')->nullable();
            $table->integer('min_learner')->nullable();
            $table->integer('max_learner')->nullable();
            $table->integer('number_of_meets')->nullable();
            $table->integer('total_of_meets')->nullable();
            $table->enum('language', [1, 2, 3])
                ->default(1)
                ->comment('1: Japanese; 2: English; 3: Vietnamese');
            $table->string('cover_image')->nullable();
            $table->string('short_video_for_parent')->nullable();
            $table->string('short_video_for_learner')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('template')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', [0, 1, 2])
                ->default(1)
                ->comment('0: Inactive; 1: Active; 2: Draft');
            $table->enum('style', [1, 2])
                ->default(1)
                ->comment('1: Interview, 2: Personal');
            $table->enum('currency', [1, 2, 3])
                ->default(1)
                ->comment('1: Dollar, 2: Yen, 3: VND')
                ->nullable();
            $table->integer('lesson_hour')->nullable();
            $table->integer('lesson_minute')->nullable();
            $table->text('lesson_content')->nullable();
            $table->text('teacher_experience')->nullable();
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
        Schema::dropIfExists('lessons');
    }
};
