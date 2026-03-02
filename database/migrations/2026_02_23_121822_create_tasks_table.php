<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Make sure the users table exists before this migration runs!
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            // Foreign keys must match users.id type (bigIncrements → unsignedBigInteger)
            $table->unsignedBigInteger('assigned_to');
            $table->unsignedBigInteger('created_by');

            $table->dateTime('due_date')->nullable();
            $table->uuid('tenant_id');

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            // Index for faster queries
            $table->index(['status', 'assigned_to', 'tenant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};