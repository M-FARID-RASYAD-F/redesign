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
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->index(['jenjang', 'status', 'created_at'], 'idx_ppdb_jenjang_status_created');
            $table->index('status', 'idx_ppdb_status');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index(['module', 'created_at'], 'idx_activity_module_created');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->index(['published_at', 'created_at'], 'idx_news_published_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropIndex('idx_ppdb_jenjang_status_created');
            $table->dropIndex('idx_ppdb_status');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_activity_module_created');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('idx_news_published_created');
        });
    }
};
