<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug'])]
class NewsCategory extends Model
{
    // Relasi 1 to M
    public function news(): HasMany {
        return $this->hasMany(News::class);
    }
}