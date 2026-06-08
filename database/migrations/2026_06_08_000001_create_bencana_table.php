<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: bencana
     * Menyimpan data kejadian bencana alam yang akan ditampilkan di peta interaktif.
     */
    public function up(): void
    {
        Schema::create('bencana', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bencana', 150);
            $table->enum('jenis_bencana', [
                'banjir',
                'gempa',
                'tsunami',
                'erupsi',
                'tanah_longsor',
                'lainnya',
            ]);
            $table->string('lokasi', 200);
            $table->decimal('latitude', 10, 7)->nullable();   // Koordinat GPS (Leaflet.js)
            $table->decimal('longitude', 10, 7)->nullable();  // Koordinat GPS (Leaflet.js)
            $table->date('tanggal_kejadian');
            $table->enum('status_siaga', ['waspada', 'siaga', 'awas']);
            // Warna marker: kuning=waspada, oranye=siaga, merah=awas (REQ-09)
            $table->text('deskripsi')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bencana');
    }
};
