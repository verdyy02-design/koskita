<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

public function up(): void
{
    Schema::create('keluhan', function (Blueprint $table) {
        $table->id();

        $table->foreignId('penghuni_id')
            ->constrained('penghuni')
            ->cascadeOnDelete();

        $table->foreignId('teknisi_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->string('judul');
        $table->string('kategori');
        $table->text('deskripsi');

        $table->string('status')->default('menunggu');

        $table->timestamp('tanggal_selesai')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};
