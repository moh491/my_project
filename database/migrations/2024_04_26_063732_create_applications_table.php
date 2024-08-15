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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['reviewed','accepted','rejected','pending'])->default('pending');
            $table->decimal('budget');
            $table->integer('experience_year');
            $table->string('file')->nullable();
            $table->foreignId('job_id')->constrained('company_jobs')->cascadeOnDelete();;
            $table->foreignId('freelancer_id')->constrained('freelancers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
