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
            $table->string('jenis_pangan');
            $table->string('volume'); // misalnya: 100 kg, 2 ton
            $table->unsignedBigInteger('asal_pangan'); // kabupaten_id
            $table->unsignedBigInteger('tujuan_pangan'); // kabupaten_id
            $table->date('tanggal_pengiriman');
            $table->date('estimasi_kadaluarsa')->nullable();
            $table->timestamps();
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
