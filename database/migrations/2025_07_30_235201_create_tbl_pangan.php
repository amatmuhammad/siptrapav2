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
        Schema::create('tbl_pangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produsen_id')->constrained('tbl_produsen_distributor')->onDelete('cascade');
            $table->foreignId('nama_pangan_id')->constrained('tbl_nama_pangan')->onDelete('cascade');
            $table->decimal('volume', 8, 2);

            // Asal pangan dan tujuan pangan merujuk ke tabel yang sama, harus didefinisikan manual
            $table->unsignedBigInteger('asal_pangan');
            $table->unsignedBigInteger('tujuan_pangan');

            $table->date('tanggal_pengiriman');
            $table->date('estimasi_kadaluarsa');
            $table->timestamps();

            // Relasi manual ke tbl_kabupaten
            $table->foreign('asal_pangan')->references('id')->on('tbl_kabupaten')->onDelete('cascade');
            $table->foreign('tujuan_pangan')->references('id')->on('tbl_kabupaten')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pangan');
    }
};
