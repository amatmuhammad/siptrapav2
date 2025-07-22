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
        Schema::create('tbl_distributor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_distributor');
            $table->string('alamat');
            $table->string('nama_pemilik');
            $table->string('no_telp');
            $table->string('kabupaten_id'); //tujuan distribusi
            $table->string('alamat_distributor');
            $table->string('jenis_angkutan');
            $table->string('Jenis_Pangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_distributor');
    }
};
