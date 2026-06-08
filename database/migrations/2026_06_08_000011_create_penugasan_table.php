<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relawan_id')->constrained('relawan')->cascadeOnDelete();
            $table->foreignId('bencana_id')->constrained('bencana')->cascadeOnDelete();
            $table->date('tanggal_tugas');
            $table->enum('status_tugas', ['ditugaskan', 'berlangsung', 'selesai', 'dibatalkan'])
                  ->default('ditugaskan');
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan');
    }
};
