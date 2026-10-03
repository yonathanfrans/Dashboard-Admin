<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger 
{
    public static function log(string $deskripsi, ?string $nama = null, ?string $email = null): ActivityLog
    {
        // Ambil dari session jika tidak dipass manual
        $userName = $nama ?? session('nama_user') ?? 'Admin/User';
        $userEmail = $email ?? session('email') ?? '-';

        return ActivityLog::create([
            'nama' => $userName,
            'email' => $userEmail,
            'deskripsi' => $deskripsi,
            'date_created' => now(),
        ]);
    }
}