<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('location');
            $table->string('time_zone');
            $table->string('profile')->nullable();
            $table->decimal('withdrawal_balance')->nullable();
            $table->decimal('available_balance')->nullable();
            $table->decimal('suspended_balance')->nullable();
            $table->text('about');
            $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete();;
            $table->rememberToken();
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
