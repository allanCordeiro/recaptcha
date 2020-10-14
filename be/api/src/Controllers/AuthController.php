<?php
namespace Recaptcha\Controllers;

class AuthController
{
    public function login() {
        if($_POST['inputEmail'] == 'eu.robo@teste.com' && $_POST['inputPassword'] == '123@456') {
            $key = '123456';

            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
            $payload = [
                'name' => 'Eu Robô',
                'email' => $_POST['inputEmail']
            ];

            $header = json_encode($header);
            $header = self::base64urlEncode($header);
            $payload = json_encode($payload);
            $payload = self::base64urlEncode($payload);

            $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
            $sign = self::base64urlEncode($sign);

            $token = $header . '.' . $payload . '.' . $sign;
            return $token;

        }

        throw new \Exception('Não autenticado.');
    }

    public static function checkAuth()
    {
        $http_header = apache_request_headers();

        if(isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            //$bearer = explode(' ', $http_header['Authorization']);
            $bearer = substr($http_header['Authorization'], 7);            
            $token = explode('.', $bearer);
            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];

            $valid = hash_hmac('sha256', $header . "." . $payload, '123456', true);
            
            $valid = self::base64urlEncode($valid);
            if($sign === $valid) {
                return true;
            }
        }

        return false;
    }

    private static function base64urlEncode($data)
    {
        $b64 = base64_encode($data);
        if($b64 === false) {
            return false;
        }

        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }
}