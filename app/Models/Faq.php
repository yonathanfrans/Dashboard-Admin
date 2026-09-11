<?php

namespace App\Models;

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
}
