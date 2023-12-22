<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('summary')->nullable();
            $table->integer('category_id');
            $table->integer('user_id');
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->integer('min_capacity')->nullable();
            $table->integer('max_capacity')->nullable();
            $table->text('detail')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
