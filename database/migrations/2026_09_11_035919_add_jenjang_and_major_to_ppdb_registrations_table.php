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
            if (!Schema::hasColumn('ppdb_registrations', 'jenjang')) {
                $table->enum('jenjang', ['sd', 'smp', 'smk'])->default('sd')->after('parent_phone');
            }
            if (!Schema::hasColumn('ppdb_registrations', 'major_choice')) {
                $table->string('major_choice')->nullable()->after('jenjang');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('ppdb_registrations', 'major_choice')) {
                $columnsToDrop[] = 'major_choice';
            }
            if (Schema::hasColumn('ppdb_registrations', 'jenjang')) {
                $columnsToDrop[] = 'jenjang';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
