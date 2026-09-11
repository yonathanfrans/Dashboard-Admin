<?php

namespace App\Models;

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
}
