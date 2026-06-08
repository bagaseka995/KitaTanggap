<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * REQ-22: Tabel laporan_distribusi.
     * Menyimpan rincian penggunaan dana donasi per bencana untuk transparansi publik.
     */
    public function up(): void
    {
        Schema::create('laporan_distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bencana_id')->constrained('bencana')->cascadeOnDelete();
            $table->text('rincian_penggunaan');
            $table->string('bukti_distribusi')->nullable(); // path file gambar/pdf
            $table->decimal('jumlah_disalurkan', 15, 2)->default(0);
            $table->timestamp('tanggal_laporan')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_distribusi');
    }
};
