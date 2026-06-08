<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->unique()->constrained('penugasan')->cascadeOnDelete();
            $table->string('kode_sertifikat', 50)->unique();
            $table->date('tanggal_terbit');
            $table->string('file_path', 255)->nullable();         // path PDF di server
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
