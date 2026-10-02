<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan', 'foto')) {
                $table->string('foto')->nullable()->after('isi');
            }
        });

        Schema::table('menu_harians', function (Blueprint $table) {
            if (!Schema::hasColumn('menu_harians', 'laporan_id')) {
                $table->foreignId('laporan_id')->nullable()->after('id')->constrained('laporan')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('menu_harians', function (Blueprint $table) {
            if (Schema::hasColumn('menu_harians', 'laporan_id')) {
                $table->dropForeign(['laporan_id']);
                $table->dropColumn('laporan_id');
            }
        });

        Schema::table('laporan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }
};