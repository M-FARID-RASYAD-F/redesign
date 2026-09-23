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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('rack_id')->nullable()->constrained('racks')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('isbn')->nullable()->unique();
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->unsignedSmallInteger('publication_year')->nullable();
            $table->unsignedInteger('pages')->nullable();
            $table->unsignedInteger('stock')->default(1);
            $table->unsignedInteger('available_stock')->default(1);
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 30)->default('tersedia');
            $table->timestamps();

            // Indexes for search and query performance
            $table->index('title');
            $table->index('author');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
