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
        Schema::create('mst_sub_alat_tangkap', function (Blueprint $table) {
            $table->smallIncrements('id_sub_alat_tangkap');
            $table->string('id_sub_alat_tangkap_lama', 10)->nullable();
            $table->integer('id_sub_alat_tangkap_baru')->nullable();
            $table->smallInteger('id_alat_tangkap')->nullable();
            $table->string('keterangan')->index();
            $table->string('nama_alat_tangkap_epit')->nullable()->index();
            $table->string('kelompok_api_izin')->nullable();
            $table->string('nm_alat_tangkap_en', 150)->nullable();
            $table->string('keterangan_group', 50)->nullable();
            $table->integer('jumlah_hari_melaut')->nullable();
            $table->string('list_jenis_izin')->nullable();
            $table->string('alat_tangkap_pnbp')->nullable()->index();
            $table->integer('fishing_gear_id')->nullable();
            $table->string('id_alat_tangkap_pusdatin', 36)->nullable();
            $table->integer('id_jenis_izin')->nullable();
            $table->decimal('koefisien_produktivitas', 3, 2)->nullable();
            $table->decimal('konversi_palkah', 3, 2)->nullable();
            $table->integer('id_sub_alat_tangkap_migrasi')->nullable();
            $table->set('flag_pasca_produksi', ['YA', 'TIDAK'])->nullable();
            $table->integer('kuota_kapal')->nullable();
            $table->integer('harga_ikan_kg')->nullable();
            $table->string('alat_tangkap_sama')->nullable();
            $table->string('display')->nullable();
            $table->string('alat_tangkap_alias')->nullable();
            $table->string('kode_alat_tangkap', 15)->nullable();
            $table->set('status_satu_kesatuan_usaha', ['YA', 'TIDAK'])->nullable();
            $table->set('status_pengangkut', ['TIDAK', 'YA'])->default('TIDAK')->nullable();
            $table->set('status_rumpon', ['YA', 'TIDAK'])->default('TIDAK')->nullable();
            $table->set('status_armada', ['ARMADA', 'TUNGGAL'])->default('')->nullable();
            $table->smallInteger('id_pengguna_buat')->unsigned()->nullable();
            $table->dateTime('tanggal_buat')->nullable();
            $table->smallInteger('id_pengguna_ubah')->unsigned()->nullable();
            $table->dateTime('tanggal_ubah')->nullable();
            $table->smallInteger('id_pengguna_hapus')->unsigned()->nullable();
            $table->dateTime('tanggal_hapus')->nullable();
            $table->integer('periode_izin')->nullable();
            $table->set('aktif', ['TIDAK', 'YA'])->default('YA')->nullable();
            $table->decimal('id2000', 15, 0)->nullable();
            $table->string('group_api', 200)->nullable();
            $table->set('grup_api_silat', ['Kapal Penangkap', 'Kapal Pengangkut', 'Rumpon'])->default('')->nullable();
            $table->string('kelompok_api')->nullable();
            $table->set('kelompok_alat_tangkap', ['KAPAL TANGKAP', 'KAPAL ANGKUT PORT TO PORT', 'KAPAL ANGKUT BUDIDAYA', 'KAPAL PEMBANTU OPERASIONAL', 'KAPAL ANGKUT DPI TO PORT'])->default('')->nullable();
            $table->string('kode_kbli')->nullable();
            $table->string('validasi_ukuran_kapal', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_sub_alat_tangkap');
    }
};
