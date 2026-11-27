<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('pembayaran', function (Blueprint $table) {
        $table->id();

        $table->foreignId('penghuni_id')
              ->constrained('penghuni')
              ->cascadeOnDelete();

        $table->string('periode', 20);
        $table->decimal('jumlah', 12, 2);
        $table->date('tanggal_bayar')->nullable();

        $table->string('bukti_pembayaran')->nullable();

        $table->enum('status', [
            'pending',
            'diterima',
            'ditolak'
        ])->default('pending');

        $table->text('catatan')->nullable();

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('pembayaran');
}
};