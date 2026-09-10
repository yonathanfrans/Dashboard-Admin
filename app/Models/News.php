<?php

namespace App\Models;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['heading', 'slug', 'date_news', 'jns_file', 'flag_kegiatan', 'thumbnail_image', 'large_image', 'content', 'source', 'show_since', 'off_from', 'video_url', 'video_url_smaller', 'counter', 'publish', 'id_user'])]
class News extends Model
{
    protected $table = 'trs_portal_berita';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'entry_date' => 'datetime',
            'date_news' => 'date',
            'off_from' => 'date',
            'show_since' => 'date',
        ];
    }

    // Mengubah $news->id menjadi ID terenkripsi di blade
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