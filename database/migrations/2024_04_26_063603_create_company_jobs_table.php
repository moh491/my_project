<?php

use App\Enums\Employment_Type;
use App\Enums\Level;
use App\Enums\Location_Type;
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
        Schema::create('company_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('location_type',Location_Type::getValues());
            $table->enum('employment_type',Employment_Type::getValues());
            $table->enum('level',Level::getValues());
            $table->text('description');
            $table->decimal('min_salary');
            $table->decimal('max_salary');
            $table->json('responsibilities')->nullable();
            $table->json('requirements')->nullable();
            $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete();;
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();;
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
