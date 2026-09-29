<?php

namespace App\Models;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nomor_formulir', 'nama', 'unit_kerja', 'telepon', 'email', 'jns_permintaan', 'jns_akses', 'keterangan_aplikasi', 'keterangan_lainnya', 'kebutuhan_permintaan', 'sifat_akses', 'waktu_akses', 'keterangan_waktu_lainnya', 'masa_berlaku', 'setuju_ketentuan', 'status', 'aktif', 'url_form_akses', 'url_api', 'catatan_api', 'url_panduan', 'date_created', 'date_modified'])]
class AccessRequest extends Model
{
    protected $table = 'access_request';

    public $timestamps = true;

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    protected function casts(): array
    {
        return [
            'jns_akses' => 'array',
            'masa_berlaku' => 'date',
            'setuju_ketentuan' => 'boolean',
            'date_created' => 'datetime',
            'date_modified' => 'datetime',
        ];
    }

    // Mengubah $item->id menjadi ID terenkripsi di blade
    public function getRouteKey() 
    {
        $encryptionService = app(EncryptionService::class);
        $encrypted = $encryptionService->enctStr((string) $this->getKey());
        return str_replace(['+', '/', '='], ['-', '_', ''], $encrypted);
    }

    // Mendeskripsi ID dari URL ketika diterima Controller
    public function resolveRouteBinding($value, $field = null)
    {
        $encryptionService = app(EncryptionService::class);

        $base64 = str_replace(['-', '_'], ['+', '/'], $value); // Mengembalikan tanda plus dan garis miring

        $mod4 = strlen($base64) % 4;
        if ($mod4) {
            $base64 .= substr('====', $mod4);
        }

        $decryptedId = $encryptionService->decStr($base64);

        if ($decryptedId === false || !ctype_digit($decryptedId) || (int) $decryptedId <= 0 ) {
            abort(404); // Jika dekripsi gagal, kembalikan 404
        }

        return $this->where($this->getKeyName(), $decryptedId)->firstOrFail();
    }
}
