<?php

namespace App\Helpers;

use Vinkla\Hashids\Facades\Hashids;

class HashId
{
    // Encode ID ke hash string
    public static function encode($id): string 
    {
        return Hashids::encode($id);
    }

    // Decode hash string kembali ke ID
    public static function decode($hash): ?int
    {
        $decoded = Hashids::decode($hash);

        return !empty($decoded) ? $decoded[0] : null;
    }
} 