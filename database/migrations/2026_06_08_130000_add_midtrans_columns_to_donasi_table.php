<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * REQ-20: Tambah kolom kode_transaksi dan snap_token
     * untuk integrasi Midtrans Snap payment gateway.
     */
    public function up(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->string('kode_transaksi', 50)->unique()->nullable()->after('id');
            $table->string('snap_token')->nullable()->after('status_bayar');
            $table->string('midtrans_transaction_id')->nullable()->after('snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropColumn(['kode_transaksi', 'snap_token', 'midtrans_transaction_id']);
        });
    }
};
