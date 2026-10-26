<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // SQLite cannot add NOT NULL columns in alter table
            $table->unsignedBigInteger('user_id')
                  ->nullable()
                  ->after('id');

            // Optional: foreign key (SQLite ignores this but MySQL/Postgres use it)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Remove FK only if DB supports it
            // $table->dropForeign(['user_id']);

            $table->dropColumn('user_id');
        });
    }
};
