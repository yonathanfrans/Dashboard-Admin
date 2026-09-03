<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['news_category_id', 'title', 'slug', 'thumbnail', 'content', 'sumber', 'status', 'tgl_publish'])]
class News extends Model
{
    // Relasi M to 1
    public function newsCategory(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class);
    }

    // Relasi 1 to M
    public function files(): HasMany
    {
        return $this->hasMany(NewsFile::class);
    }

    protected function casts(): array
    {
        return [
            'tgl_publish' => 'date',
        ];
    }
}