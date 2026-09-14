<?php

namespace App\Models;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id_sub', 'menu', 'sub_menu', 'no_urut', 'aktif'])]
class FaqMenu extends Model
{
    protected $table = 'faq_menu';
    protected $primaryKey = 'id_sub';

    public $incrementing = false;
    public $timestamps = false;

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'id_sub', 'id_sub');
    }

    // Mengubah $faqMenu->id menjadi ID terenkripsi di blade
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
