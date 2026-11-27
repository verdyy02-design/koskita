<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {

            if (!Schema::hasColumn('pembayaran', 'penghuni_id')) {
                $table->foreignId('penghuni_id')
                    ->constrained('penghuni')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('pembayaran', 'bulan')) {
                $table->string('bulan')->after('penghuni_id');
            }

            if (!Schema::hasColumn('pembayaran', 'jumlah')) {
                $table->decimal('jumlah', 12, 2)->after('bulan');
            }

            if (!Schema::hasColumn('pembayaran', 'tanggal_jatuh_tempo')) {
                $table->date('tanggal_jatuh_tempo')->after('jumlah');
            }

            if (!Schema::hasColumn('pembayaran', 'tanggal_bayar')) {
                $table->date('tanggal_bayar')->nullable()->after('tanggal_jatuh_tempo');
            }

            if (!Schema::hasColumn('pembayaran', 'status')) {
                $table->enum('status', [
                    'belum_lunas',
                    'lunas'
                ])->default('belum_lunas')->after('tanggal_bayar');
            }

            if (!Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('status');
            }

        });
    }

    public function down(): void
    {
        //
    }
};