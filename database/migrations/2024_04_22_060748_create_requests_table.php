<?php

use App\Enums\Status;
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
            $table->text('note');
            $table->string('files')->nullable();
            $table->enum('status',Status::getValues())->default(Status::PENDING);
            $table->integer('rating')->nullable();
            $table->foreignId('project_owner_id')->constrained('project__owners')->cascadeOnDelete();;
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();;
            $table->timestamps();
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
