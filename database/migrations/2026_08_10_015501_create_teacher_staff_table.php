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
        Schema::create('teacher_staff', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('position');       // mis. Kepala Sekolah, Guru, Staf TU
    $table->string('subject')->nullable();
    $table->string('photo')->nullable();
    $table->string('nip')->nullable();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_staff');
    }
};
