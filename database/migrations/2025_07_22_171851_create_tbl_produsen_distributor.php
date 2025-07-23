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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_distributor');
            $table->string('no_hp');
            $table->string('nama_pemilik');
            $table->string('jenis_pangan');
            $table->string('jenis_distributor'); // petani, grosir, retail, dll
            $table->unsignedBigInteger('asal'); // kabupaten_id
            $table->unsignedBigInteger('tujuan_distribusi'); // kabupaten_id
            $table->text('alamat_distributor');
            $table->string('wilayah_cakupan')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
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
