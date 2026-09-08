<?php

namespace App\Services;

class EncryptionService
{
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
}