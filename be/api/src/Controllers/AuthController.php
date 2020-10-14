<?php
namespace Recaptcha\Controllers;

class AuthController
{
    public function login() {
        if($_POST['inputEmail'] == 'eu.robo@teste.com' && $_POST['inputPassword'] == '123@456') {
            $key = '123456';

            $header = [
                'typ' => 'JWT',
                'alg' => 'H256'
            ];
            $payload = [
                'name' => 'Eu Robô',
                'email' => $_POST['inputEmail']
            ];

            $header = json_encode($header);
            $payload = json_encode($payload);

            $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
            $sign = $this->base64urlEncode($sign);

            $token = $header . '.' . $payload . '.' . $sign;
            return $token;

        }

        throw new \Exception('Não autenticado.');
    }

    public static function checkAuth()
    {
        $http_header = apache_request_headers();

        if(isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            $bearer = explode(' ', $http_header['Authorization']);

            $token = explode('.', $bearer[1]);
            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];

            $valid = hash_hmac('sha256', $header . "." . $payload, '123456', true);
            $b64encode = new base64urlEncode();
            $valid = $b64encode->base64urlEncode($valid);

            if($sign === $valid) {
                return true;
            }
        }

        return false;
    }

    private function base64urlEncode($data)
    {
        $b64 = base64_encode($data);
        if($b64 === false) {
            return false;
        }

        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }
}