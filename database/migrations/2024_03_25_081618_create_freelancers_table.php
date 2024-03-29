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
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
//            $table->bigInteger('field_id');
//            $table->foreign('field_id')->references('id')->on('fields');
//            $table->bigInteger('position_id');
//            $table->foreign('position_id')->references('id')->on('positions');
//            $table->foreignId('field_id')->constrained('fields')->cascadeOnDelete()->cascadeOnUpdate();
//            $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('about');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
