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
        Schema::create('teacher_informations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('teacher_id');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100);
            $table->string('birthday', 20);
            $table->string('country_code', 50);
            $table->string('phone', 20);
            $table->string('headline', 80);
            $table->string('about', 200);
            $table->string('introduction_video')->nullable();
            $table->string('bank_name', 50);
            $table->string('branch_code', 50);
            $table->enum('account_type', [0, 1])
                ->default(0)
                ->comment(
                    '0: 普通口座/Tài khoản thông thường;
                    1: 法人口座/Tài khoản pháp nhân (kiểu công ty)'
                );
            $table->string('account_number', 50);
            $table->string('account_name', 50);
            $table->string('profile_image');
            $table->string('card_image_front')->nullable();
            $table->string('card_image_back')->nullable();
            $table->string('school')->nullable();
            $table->string('major')->nullable();
            $table->string('major_specialize')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('academic_certificate')->nullable();
            $table->enum('job', [1, 2, 3, 4, 5, 6, 7, 8, 9])
                ->default(1)
                ->comment(
                    '1:公務員
                    2:経営者・役員　
                    3:会社員
                    4:自営業
                    5:自由業
                    6:専業主婦
                    7:パート・アルバイト
                    8:学生
                    9:その他'
                );
            $table->enum('salary', [1, 2, 3, 4, 5, 6, 7, 8])
                ->default(1)
                ->comment(
                    '1:100万円以下
                    2:100万円～195万以下
                    3:195万円～330万円以下
                    4:330万円～695万円以下
                    5:695万円～900万円以下
                    6:900万円～1800万円以下
                    7:1800万円～4000万円以下
                    8:4000万円超'
                );
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
        Schema::dropIfExists('teacher_informations');
    }
};
