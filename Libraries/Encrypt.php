<?php

namespace Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Encrypt
{
    //@var string $jwt_secret jwt_secret
    private static $jwt_secret = "59gsv4Bn7VcEyM10uiZiyY72l2KJp31N";

    /**
     * encryptJwt
     *
     * @param  string $string string to encrypt
     * @throws \Exception
     * @return array
     */
    public static function encryptJwt($string)
    {
        $time = time()-1;
        $exp = $time + 6000;
        $payload = [
            'sub' => $string,
            'iss' => $_SERVER['HTTP_HOST'] ?? 'local',
            'aud' => $_SERVER['HTTP_USER_AGENT'] ?? 'local',
            'iat' => $time,
            'exp' => $exp
        ];
        $headers = [];
        try {
            return ["token" => JWT::encode($payload, self::$jwt_secret, 'HS256', null, $headers), "expire" => $exp];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

}