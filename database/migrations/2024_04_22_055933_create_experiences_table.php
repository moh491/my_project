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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->enum('employment_type',['Full_time','Part_time','Self_employed','Freelance','Contract','Internship','Seasonal','Apprenticeship']);
            $table->enum('location_type',['On-site','Hybrid','Remote']);
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->foreignId('freelancer_id');
            $table->foreignId('position_id');
            $table->foreignId('company_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
