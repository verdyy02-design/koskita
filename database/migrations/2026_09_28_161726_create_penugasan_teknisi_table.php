<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('penugasan_teknisi', function (Blueprint $table) {
        $table->id();

        $table->foreignId('keluhan_id')
              ->constrained('keluhan')
              ->cascadeOnDelete();

        $table->foreignId('teknisi_id')
              ->constrained('teknisi')
              ->cascadeOnDelete();

        $table->dateTime('tanggal_penugasan');

        $table->text('catatan')->nullable();

        $table->enum('status', [
            'ditugaskan',
            'diproses',
            'selesai'
        ])->default('ditugaskan');

        $table->dateTime('selesai_at')->nullable();

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('penugasan_teknisi');
}
};