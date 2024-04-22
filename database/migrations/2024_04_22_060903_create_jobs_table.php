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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->enum('location_type',['On-site','Hybrid','Remote']);
            $table->enum('employment_type',['Full_time','Part_time','Self_employed','Freelance','Contract','Internship','Seasonal','Apprenticeship']);
            $table->enum('level',['junior' , 'senior' , 'mid']);
            $table->text('description');
            $table->decimal('min_salary');
            $table->decimal('max_salary');
            $table->text('responsibilities');
            $table->foreignId('field_id');
            $table->foreignId('position_id');
            $table->foreignId('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
