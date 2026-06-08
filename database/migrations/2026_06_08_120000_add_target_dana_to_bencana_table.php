<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * REQ-19: Tambah kolom target_dana ke tabel bencana.
     * Digunakan untuk menampilkan progress bar donasi per bencana.
     */
    public function up(): void
    {
        Schema::table('bencana', function (Blueprint $table) {
            $table->decimal('target_dana', 15, 2)->default(0)->after('status_aktif');
        });
    }

    public function down(): void
    {
        Schema::table('bencana', function (Blueprint $table) {
            $table->dropColumn('target_dana');
        });
    }
};
