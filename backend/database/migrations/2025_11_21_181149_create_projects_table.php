<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();                          // Primary key (auto increment)
            $table->string('name');                // Project name
            $table->text('description')->nullable(); // Optional long text
            $table->string('status')->default('open'); // open/closed/paused
            $table->timestamps();                  // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
