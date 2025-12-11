<?php

namespace App\Helpers;

class AESCipher
{
    protected static function key()
    {
        return hash('sha256', env('AES_KEY', env('APP_KEY')), true);
    }

    public static function encrypt($value)
    {
        if (!$value) return null;

        $iv = random_bytes(16); // AES-256-CBC IV = 16 byte
        $cipher = openssl_encrypt($value, 'AES-256-CBC', self::key(), OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $cipher); // gabung iv + cipher
    }

    public static function decrypt($value)
    {
        if (!$value) return null;

        $data = base64_decode($value);
        $iv   = substr($data, 0, 16);
        $cipher = substr($data, 16);

        return openssl_decrypt($cipher, 'AES-256-CBC', self::key(), OPENSSL_RAW_DATA, $iv);
    }
}
