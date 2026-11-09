<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SubAlatTangkap extends Model
{
    protected $table = 'mst_sub_alat_tangkap';
    protected $primaryKey = 'id_sub_alat_tangkap';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'tanggal_buat' => 'datetime',
            'tanggal_ubah' => 'datetime',
            'tanggal_hapus' => 'datetime',
        ];
    }
}
