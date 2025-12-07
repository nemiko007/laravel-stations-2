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
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('published_year')->after('image_url');
            $table->boolean('is_showing')->default(false)->after('published_year');
            $table->text('description')->after('is_showing');
            $table->foreignId('genre_id')->after('description')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['published_year', 'is_showing', 'description', 'genre_id']);
        });
    }
};
