<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * REQ-19: Tabel donasi.
     * Menyimpan data donasi per bencana dari pengguna (baik terdaftar maupun anonim).
     */
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bencana_id')->constrained('bencana')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_donatur', 100);
            $table->string('email_donatur', 100);
            $table->decimal('nominal', 15, 2);
            $table->text('pesan')->nullable();
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet', 'kartu_kredit'])->default('transfer_bank');
            $table->enum('status_bayar', ['pending', 'sukses', 'gagal'])->default('pending');
            $table->string('bukti_transfer')->nullable(); // path file bukti
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
