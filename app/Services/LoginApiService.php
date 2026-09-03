<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LoginApiService
{
    private string $url;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->url = config('services.login_api.url');
    }

    public function enctStr(string $pureString): string
    {
        $key = 'D!TuP19#@3!@$51l@T|' . date('dmy');
        $cipherMethod = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($cipherMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encryptedString = openssl_encrypt($pureString, $cipherMethod, $key, 0, $iv);

        return base64_encode($iv . '::' . $encryptedString);
    }

    public function decStr(string $encryptedString): string|false
    {
        $key = 'D!TuP19#@3!@$51l@T|' . date('dmy');
        $cipherMethod = 'AES-256-CBC';
        $decryptedData = explode('::', base64_decode($encryptedString), 2);

        if (count($decryptedData) === 2) {
            [$iv, $encrytedData] = $decryptedData;

            return openssl_decrypt($encrytedData, $cipherMethod, $key, 0, $iv);
        }
        
        return false;
    }

    public function login(string $username, string $password): array {
        $payload = [
            'par1' => md5('WEBPORTAL'),
            'par2' => md5(base64_encode(date('m') . '5' . date('y') . '@!' . date('Y') . '#' . date('d') . '$' . date('M') . '!')),
            'par3' => $this->enctStr('LOGIN'),
            'par4' => $this->enctStr('GETTOKEN'),
            'par5' => $this->enctStr($username),
            'par6' => $this->enctStr($password)
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