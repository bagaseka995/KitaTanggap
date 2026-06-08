<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('keahlian', 255)->nullable();          // "medis,SAR,logistik"
            $table->text('pengalaman')->nullable();
            $table->string('lokasi_domisili', 150)->nullable();
            $table->boolean('ketersediaan')->default(true);
            $table->enum('status_verifikasi', ['pending', 'terverifikasi', 'ditolak'])
                  ->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relawan');
    }
};
