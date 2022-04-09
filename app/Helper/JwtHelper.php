<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function getSecretKey()
    {
        return env('JWT_SECRET', 'kMoAR6j0MXHrBB4');
    }

    public static function make($payload, $expired = null)
    {
        $key = static::getSecretKey();
        $token = JWT::encode(array_merge($payload, [
            'expired' => $expired ?? strtotime("+10 minutes"),
            'type' => 'token'
        ]), $key, 'HS256');

        return $token;
    }

    public static function parse($jwt)
    {
        $key = static::getSecretKey();
        return (array)JWT::decode($jwt, new Key($key, 'HS256'));
    }

    public static function isExpired($jwt)
    {
        $payload = static::parse($jwt);

        $tokenLifeTime = $payload['expired'];

        $currentTime = time();

        if ($currentTime > $tokenLifeTime) {
            return true;
        }
        return $payload;
    }
}
