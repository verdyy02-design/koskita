<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('penghuni', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->unique()
              ->constrained('users')
              ->cascadeOnDelete();

        $table->foreignId('kamar_id')
              ->nullable()
              ->constrained('kamar')
              ->nullOnDelete();

        $table->string('nik', 16)->unique();
        $table->string('no_hp', 20);
        $table->text('alamat')->nullable();
        $table->date('tanggal_masuk');
        $table->date('tanggal_keluar')->nullable();

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('penghuni');
}
};