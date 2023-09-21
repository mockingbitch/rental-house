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
        Schema::create('teacher_work_histories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('teacher_id');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('work_position');
            $table->enum('recruitment_form', [0, 1, 2, 3, 4])
                ->default(1)
                ->comment(
                    '・0: 正社員
                    ・1: 契約社員
                    ・2: パート・アルバイト
                    ・3: 派遣社員
                    ・4: 業務委託'
                );
            $table->string('company');
            $table->date('work_start_date');
            $table->date('work_end_date');
            $table->enum('is_still_working', [0, 1])
                ->default(1)
                ->comment('0: no; 1: yes');
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
        Schema::dropIfExists('teacher_work_histories');
    }
};
