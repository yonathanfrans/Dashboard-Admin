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
        Schema::create('vw_tracking_siup', function (Blueprint $table) {
            $table->unsignedBigInteger('id_permohonan_izin')->primary();
            $table->string('status_permohonan')->default('PROSES');
            $table->integer('id_status_izin');
            $table->string('nomor_agenda')->index();            
            $table->date('tanggal_permohonan');
            $table->dateTime('tanggal_kirim_pendok');
            $table->string('nama_pemilik');
            $table->string('keterangan')->nullable();
            $table->string('nama_jenis_izin')->default('SIUP');
            $table->string('nama_status_izin');
            $table->string('nomor_izin')->nullable()->index();
            $table->string('actions')->nullable();

            $table->string('progress1')->nullable();
            $table->string('progress3')->nullable();
            $table->string('progress4')->nullable();
            $table->string('progress5')->nullable();
            $table->string('progress7a')->nullable();
            $table->string('progress7b')->nullable();

            $table->text('catatan_stop_proses')->nullable();
            $table->tinyInteger('status_batal')->default(0);
            $table->string('waktu_7b1')->nullable();
            $table->string('waktu_7b2')->nullable();
            $table->string('status_terbit')->default('PROSES');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vw_tracking_siup');
    }
};
