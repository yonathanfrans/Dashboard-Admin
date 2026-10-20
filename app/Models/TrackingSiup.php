<?php

namespace App\Models;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['id_permohonan_izin', 'status_permohonan', 'id_status_izin', 'nomor_agenda', 'tanggal_permohonan', 'tanggal_kirim_pendok', 'nama_pemilik', 'keterangan', 'nama_jenis_izin', 'nama_status_izin', 'nomor_izin', 'actions', 'progress1', 'progress3', 'progress4', 'progress5', 'progress7a', 'progress7b', 'catatan_stop_proses', 'status_batal', 'waktu_7b1', 'waktu_7b2', 'status_terbit'])]
class TrackingSiup extends Model
{
    use HasFactory;

    protected $table = 'vw_tracking_siup';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'tanggal_permohonan' => 'date',
            'tanggal_kirim_pendok' => 'datetime',
            'status_batal' => 'boolean',
        ];
    }

    // public function getParsedProgress(string $field): ?array
    // {
    //     $value = $this->{$field};
    //     if (!$value) return null;

    //     $parts = explode('|', $value);
    //     return [
    //         'start' => trim($parts[0] ?? ''),
    //         'end' => trim($parts[1] ?? ($parts[0] ?? '')),
    //     ];
    // }

}
