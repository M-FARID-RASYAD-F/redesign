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
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->string('full_name');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth_date');
            $table->text('address');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('major_choice');
            $table->enum('status', ['pending', 'diverifikasi', 'diterima', 'ditolak'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
