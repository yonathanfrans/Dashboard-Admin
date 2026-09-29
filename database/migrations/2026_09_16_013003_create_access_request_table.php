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
        Schema::create('access_request', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_formulir')->unique();
            
            $table->string('nama');
            $table->string('unit_kerja');
            $table->string('telepon', 20);
            $table->string('email');

            $table->enum('jns_permintaan', ['pendaftaran', 'penutupan'])->default('pendaftaran');
            $table->json('jns_akses');
            $table->string('keterangan_aplikasi')->nullable();
            $table->string('keterangan_lainnya')->nullable();

            $table->string('kebutuhan_permintaan');

            $table->enum('sifat_akses', ['rutin', 'sementara', 'selalu_aktif']);
            $table->enum('waktu_akses', ['7x24_jam', 'jam_kerja', 'lainnya']);
            $table->string('keterangan_waktu_lainnya')->nullable();
            $table->date('masa_berlaku');

            $table->boolean('setuju_ketentuan')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('aktif', ['Y', 'T'])->default('T');

            $table->string('url_form_akses', 255);
            $table->string('url_api', 255);
            $table->string('catatan_api')->nullable();
            $table->string('url_panduan', 255);
            
            $table->dateTime('date_created');
            $table->dateTime('date_modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_request');
    }
};
