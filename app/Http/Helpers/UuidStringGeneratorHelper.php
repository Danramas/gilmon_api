<?php

namespace App\Http\Helpers;

class UuidStringGeneratorHelper
{
    public static function generateUuidString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uuidString = '';

        for ($i = 0; $i < 32; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $uuidString .= $characters[$index];
        }

        return $uuidString;
    }
}


