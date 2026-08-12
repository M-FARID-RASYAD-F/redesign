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
        Schema::create('ppdb_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('registration_id')->constrained('ppdb_registrations')->cascadeOnDelete();
    $table->enum('doc_type', ['kk', 'akta_lahir', 'foto', 'rapor_terakhir']);
    $table->string('file_path');
    $table->enum('verification_status', ['belum_diverifikasi', 'valid', 'tidak_valid'])
          ->default('belum_diverifikasi');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_documents');
    }
};
