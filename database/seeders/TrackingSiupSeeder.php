<?php

namespace Database\Seeders;

use App\Models\TrackingSiup;
use Illuminate\Database\Seeder;

class TrackingSiupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_permohonan_izin' => 408526,
                'status_permohonan' => 'PROSES',
                'id_status_izin' => 4,
                'nomor_agenda' => 'UPDATE-KBLI-2025',
                'tanggal_permohonan' => '2026-10-07',
                'tanggal_kirim_pendok' => '2026-10-07 15:12:00',
                'nama_pemilik' => 'MARIA ULFA',
                'keterangan' => null,
                'nama_jenis_izin' => 'SIUP',
                'nama_status_izin' => 'Perubahan',
                'nomor_izin' => '02.17.01.0067.8610',
                'progress1' => '07-Okt-2026 15:10:19|07-Okt-2026 15:10:00',
                'progress3' => null,
                'progress4' => null,
                'progress5' => null,
                'progress7a' => null,
                'progress7b' => null,
                'catatan_stop_proses' => null,
                'status_batal' => 0,
                'waktu_7b1' => null,
                'waktu_7b2' => null,
                'status_terbit' => 'PROSES',
            ],
            [
                'id_permohonan_izin' => 408488,
                'status_permohonan' => 'PROSES',
                'id_status_izin' => 4,
                'nomor_agenda' => 'UPDATE-KBLI-2025',
                'tanggal_permohonan' => '2026-10-07',
                'tanggal_kirim_pendok' => '2026-10-07 15:12:00',
                'nama_pemilik' => 'KUB. BIDADARI',
                'keterangan' => 'KUB. BIDADARI (SAHRIL DJ. HASIM)',
                'nama_jenis_izin' => 'SIUP',
                'nama_status_izin' => 'Perubahan',
                'nomor_izin' => '02.16.01.0162.7990',
                'progress1' => '07-Okt-2026 13:10:06|07-Okt-2026 13:10:47',
                'progress3' => '07-Okt-2026 14:10:15|07-Okt-2026 14:10:15',
                'progress4' => '07-Okt-2026 14:10:15|07-Okt-2026 14:10:15',
                'progress5' => null,
                'progress7a' => '07-Okt-2026 14:10:15|07-Okt-2026 14:10:15',
                'progress7b' => null,
                'catatan_stop_proses' => null,
                'status_batal' => 0,
                'waktu_7b1' => null,
                'waktu_7b2' => null,
                'status_terbit' => 'PROSES',
            ],
            [
                'id_permohonan_izin' => 408514,
                'status_permohonan' => 'PROSES',
                'id_status_izin' => 1,
                'nomor_agenda' => '425773/2026',
                'tanggal_permohonan' => '2026-10-07',
                'tanggal_kirim_pendok' => '2026-10-07 14:52:01',
                'nama_pemilik' => 'WILLISON CHONELLIUS',
                'keterangan' => null,
                'nama_jenis_izin' => 'SIUP',
                'nama_status_izin' => 'Baru',
                'nomor_izin' => null,
                'progress1' => '07-Okt-2026 14:10:59|07-Okt-2026 14:10:01',
                'progress3' => null,
                'progress4' => null,
                'progress5' => null,
                'progress7a' => null,
                'progress7b' => null,
                'catatan_stop_proses' => null,
                'status_batal' => 0,
                'waktu_7b1' => null,
                'waktu_7b2' => null,
                'status_terbit' => 'PROSES',
            ],
            [
                'id_permohonan_izin' => 408472,
                'status_permohonan' => 'PROSES',
                'id_status_izin' => 1,
                'nomor_agenda' => '425729/2026',
                'tanggal_permohonan' => '2026-10-07',
                'tanggal_kirim_pendok' => '2026-10-07 12:00:49',
                'nama_pemilik' => 'ANTONIUS HARTANTO',
                'keterangan' => null,
                'nama_jenis_izin' => 'SIUP',
                'nama_status_izin' => 'Baru',
                'nomor_izin' => null,
                'progress1' => '07-Okt-2026 10:10:13|07-Okt-2026 12:10:49',
                'progress3' => null,
                'progress4' => null,
                'progress5' => null,
                'progress7a' => null,
                'progress7b' => null,
                'catatan_stop_proses' => null,
                'status_batal' => 0,
                'waktu_7b1' => null,
                'waktu_7b2' => null,
                'status_terbit' => 'PROSES',
            ],
            [
                'id_permohonan_izin' => 408487,
                'status_permohonan' => 'PROSES',
                'id_status_izin' => 4,
                'nomor_agenda' => '425746/2026',
                'tanggal_permohonan' => '2026-10-07',
                'tanggal_kirim_pendok' => '2026-10-07 13:06:14',
                'nama_pemilik' => 'DJUMADI',
                'keterangan' => 'SAUDARA BERSAMA 5',
                'nama_jenis_izin' => 'SUBSEKTOR PENANGKAPAN IKAN DI WPPNRI',
                'nama_status_izin' => 'Perubahan',
                'nomor_izin' => '33.25.0001.136.87294',
                'progress1' => '07-Okt-2026 12:10:43|07-Okt-2026 13:10:14',
                'progress3' => null,
                'progress4' => null,
                'progress5' => null,
                'progress7a' => null,
                'progress7b' => null,
                'catatan_stop_proses' => null,
                'status_batal' => 0,
                'waktu_7b1' => null,
                'waktu_7b2' => null,
                'status_terbit' => 'PROSES',
            ],
        ];

        foreach ($data as $item) {
            TrackingSiup::updateOrCreate(
                ['id_permohonan_izin' => $item['id_permohonan_izin']],
                $item
            );
        }
    }
}
