<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['news_id', 'file'])]
class NewsFile extends Model
{
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
