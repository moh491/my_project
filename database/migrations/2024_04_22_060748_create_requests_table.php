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
            $table->string('files');
            $table->decimal('budget');
            $table->enum('status',Status::getValues());
            $table->foreignId('project_owner_id')->constrained('project__owners')->cascadeOnDelete();;
            $table->foreignId('delivery_option_id')->constrained('delivery__options')->cascadeOnDelete();;
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
