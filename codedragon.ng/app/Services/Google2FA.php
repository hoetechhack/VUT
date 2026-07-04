<?php

namespace App\Services;

class Google2FA
{
    private static $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    public static function generateSecretKey($length = 16)
    {
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= self::$base32chars[random_int(0, 31)];
        }
        return $secret;
    }

    public static function getQRCodeUrl($companyName, $companyEmail, $secret)
    {
        $companyName = urlencode($companyName);
        $companyEmail = urlencode($companyEmail);
        $otpauth = "otpauth://totp/{$companyName}:{$companyEmail}?secret={$secret}&issuer={$companyName}";
        
        // Using an external API to generate the QR Code image directly
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($otpauth);
    }

    public static function verifyKey($secret, $code, $window = 2)
    {
        if (strlen($code) !== 6) return false;
        
        $currentTimeSlice = floor(time() / 30);

        for ($i = -$window; $i <= $window; $i++) {
            $calculatedCode = self::getCode($secret, $currentTimeSlice + $i);
            if (hash_equals($calculatedCode, $code)) {
                return true;
            }
        }
        return false;
    }

    public static function getCode($secret, $timeSlice = null)
    {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretKey = self::base32Decode($secret);
        
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hash = hash_hmac('sha1', $time, $secretKey, true);
        
        $offset = ord(substr($hash, -1)) & 0x0F;
        
        $value = unpack('N', substr($hash, $offset, 4));
        $value = $value[1] & 0x7FFFFFFF;
        
        $code = $value % 1000000;
        
        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }

    private static function base32Decode($secret)
    {
        if (empty($secret)) return '';

        $base32chars = self::$base32chars;
        $base32charsFlipped = array_flip(str_split($base32chars));

        $paddingCharCount = substr_count($secret, '=');
        $allowedValues = [6, 4, 3, 1, 0];
        if (!in_array($paddingCharCount, $allowedValues)) return false;
        
        for ($i = 0; $i < 4; $i++) {
            if ($paddingCharCount == $allowedValues[$i] && substr($secret, -($allowedValues[$i])) != str_repeat('=', $allowedValues[$i])) {
                return false;
            }
        }
        
        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = '';
        
        foreach ($secret as $char) {
            $binaryString .= str_pad(base_convert($base32charsFlipped[$char], 10, 2), 5, '0', STR_PAD_LEFT);
        }
        
        $eightBitArray = str_split($binaryString, 8);
        $result = '';
        
        foreach ($eightBitArray as $bin) {
            if (strlen($bin) == 8) {
                $result .= chr(base_convert($bin, 2, 10));
            }
        }
        return $result;
    }
}
