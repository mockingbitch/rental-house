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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nick_name', 50)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('description')->nullable();
            $table->string('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('city_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->enum('role', [1, 2, 3])
                ->default(3)
                ->comment('1: Admin, 2: Teacher, 3:Parent/Child');
            $table->enum('status', [0, 1])
                ->default(1)
                ->comment('0: Inactive; 1: Active');
            $table->string('region', 10)->nullable();
            $table->enum('vendor', [1, 2])
                ->default(1)
                ->comment('1: Email, 2: Google');
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
        Schema::dropIfExists('users');
    }
};
