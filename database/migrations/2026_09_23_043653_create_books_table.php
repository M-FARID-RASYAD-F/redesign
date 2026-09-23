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
            $table->foreignId('category_id')->nullable()
                ->constrained('book_categories')->nullOnDelete();
            $table->string('title');
            $table->string('isbn')->nullable()->unique();
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->unsignedInteger('stock')->default(1);
            $table->unsignedInteger('available')->default(1);
            $table->string('cover')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('rack_location')->nullable();
            $table->timestamps();
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
