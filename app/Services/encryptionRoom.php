<?php

namespace app\Services;

use phpseclib3\Crypt\AES as vendorAES;

class encryptionRoom

{
    private $aes;
    private $shift = 3; // pergeseran default untuk Caesar Cipher

    public function __construct()
    {
        $this->aes = new VendorAES('gcm');

        $key = config('aes.key');
        $nonce = config('aes.nonce', null);
        $aad = config('aes.aad', null);

        $this->aes->setKey($key);
        if ($nonce) $this->aes->setNonce($nonce);
        if ($aad) $this->aes->setAAD($aad);
    }

    /**
     * Encrypt:
     * plaintext -> AES -> Caesar Cipher -> final cipher
     */
    public function encrypt(string $plain): string
    {
        // 1️⃣ AES Encrypt
        $cipher = $this->aes->encrypt($plain);
        $tag = $this->aes->getTag();

        $jsonCipher = json_encode([
            'cipher' => base64_encode($cipher),
            'tag' => base64_encode($tag),
        ]);

        $encoded = base64_encode($jsonCipher);

        // 2️⃣ Caesar Cipher tahap akhir
        $finalCipher = $this->caesarEncrypt($encoded, $this->shift);

        return $finalCipher;
    }

    /**
     * Decrypt:
     * final cipher -> Reverse Caesar Cipher -> AES decrypt -> plaintext
     */
    public function decrypt(string $cipher): string
    {
        // 1️⃣ Reverse Caesar Cipher
        $decodedCaesar = $this->caesarDecrypt($cipher, $this->shift);

        // 2️⃣ Decode Base64 + JSON
        $data = json_decode(base64_decode($decodedCaesar), true);

        if (!isset($data['cipher'], $data['tag'])) {
            throw new \Exception('Invalid cipher format');
        }

        // 3️⃣ Set AES tag dan decrypt
        $this->aes->setTag(base64_decode($data['tag']));
        $plaintext = $this->aes->decrypt(base64_decode($data['cipher']));

        return $plaintext;
    }

    /**
     * Simple Caesar Cipher (A-Z, a-z only)
     */
    private function caesarEncrypt(string $string, int $shift): string
    {
        $result = '';
        $shift = $shift % 26;

        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];

            if (ctype_alpha($char)) {
                $ascii = ord($char);
                $base = ctype_upper($char) ? ord('A') : ord('a');
                $result .= chr(($ascii - $base + $shift) % 26 + $base);
            } else {
                $result .= $char;
            }
        }
        return $result;
    }

    /**
     * Reverse Caesar Cipher
     */
    private function caesarDecrypt(string $string, int $shift): string
    {
        return $this->caesarEncrypt($string, 26 - ($shift % 26));
    }
}