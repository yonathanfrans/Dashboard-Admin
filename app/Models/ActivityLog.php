<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'email', 'deskripsi', 'date_created'])]
class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'date_created' => 'datetime'
        ];
    }
}
