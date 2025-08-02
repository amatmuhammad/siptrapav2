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
        Schema::create('tbl_produsen_distributor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_distributor');
            $table->string('no_hp');
            $table->string('nama_pemilik');
            $table->string('jenis_pangan');
            $table->string('jenis_distributor');
            
            // Referensi ke kabupaten sebagai asal distributor
            $table->foreignId('asal')->constrained('tbl_kabupaten')->onDelete('cascade');

            $table->text('alamat_distributor')->nullable();
            $table->string('wilayah_cakupan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_produsen_distributor');
    }
};
