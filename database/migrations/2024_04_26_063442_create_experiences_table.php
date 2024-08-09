<?php

use App\Enums\Employment_Type;
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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->enum('employment_type',Employment_Type::getValues());
            $table->enum('location_type',Location_Type::getValues());
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->foreignId('freelancer_id')->constrained('freelancers')->cascadeOnDelete();;
            $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete();;
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
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
