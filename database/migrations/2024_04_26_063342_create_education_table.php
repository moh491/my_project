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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('institution');
            $table->string('location');
            $table->date('start_year');
            $table->date('end_year')->nullable();
            $table->decimal('average')->nullable();
            $table->text('description');
            $table->foreignId('freelancer_id')->constrained('freelancers')->cascadeOnDelete();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
