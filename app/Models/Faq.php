<?php

namespace App\Models;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_sub', 'jenis', 'pertanyaan', 'jawaban', 'link', 'publish', 'note', 'created', 'user_id', 'counter'])]
class Faq extends Model
{
    protected $table = 'faq';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created' => 'datetime',
        ];
    }

    public function faqMenu(): BelongsTo
    {
        return $this->belongsTo(FaqMenu::class, 'id_sub', 'id_sub');
    }

    // Mengubah $faq->id menjadi ID terenkripsi di blade
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
