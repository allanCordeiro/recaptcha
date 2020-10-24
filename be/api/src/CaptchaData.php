<?php

namespace Recaptcha;

use Dotenv\Dotenv;

class CaptchaData
{
    public static function GetPublicKey()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        return $_ENV["GOOGLE_RECAPTCHA_PUBLIC_KEY"];
    }
}