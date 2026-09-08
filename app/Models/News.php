<?php

namespace App\Models;

use App\Services\LoginApiService;
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
}