<?php
return [
    'key' => env('AES_KEY', 'Wm9Oc2x5QXpHU2VzV0RkbUxtc0xUMmR2'),
    'nonce' => env('AES_NONCE', 12),
    'aad' => env('AES_AAD', 'my-app-v1'),
];