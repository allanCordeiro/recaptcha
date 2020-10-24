<?php
namespace Recaptcha\Controllers;

use Recaptcha\CaptchaData;

class PublicKeyController
{

    public function get()
    {
        return CaptchaData::GetPublicKey();
    }
}