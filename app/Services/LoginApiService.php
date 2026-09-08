<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LoginApiService
{
    private string $url;
    private EncryptionService $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        // date_default_timezone_set('Asia/Jakarta');

        $this->url = config('services.login_api.url');
        $this->encryptionService = $encryptionService;
    }

    public function login(string $username, string $password): array {
        $payload = [
            'par1' => md5('WEBPORTAL'),
            'par2' => md5(base64_encode(date('m') . '5' . date('y') . '@!' . date('Y') . '#' . date('d') . '$' . date('M') . '!')),
            'par3' => $this->encryptionService->enctStr('LOGIN'),
            'par4' => $this->encryptionService->enctStr('GETTOKEN'),
            'par5' => $this->encryptionService->enctStr($username),
            'par6' => $this->encryptionService->enctStr($password)
        ];

        $response = Http::timeout(15)->acceptJson()->asJson()->post($this->url, $payload);

        // return [
        //     'status_code' => $response->status(),
        //     'successful' => $response->successful(),
        //     'body' => $response->body(),
        //     'json' => $response->json(),
        // ];
        return $response->json();
    }
}