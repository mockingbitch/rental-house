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
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('description')->nullable();
            $table->string('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('ward_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('status')
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
