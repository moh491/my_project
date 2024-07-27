<?php

use App\Enums\Offer_Type;
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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('duration');
            $table->decimal('budget');
            $table->text('description');
            $table->enum('status',Offer_Type::getValues())->default('Pending');
            $table->string('files')->nullable();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->morphs('worker');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
