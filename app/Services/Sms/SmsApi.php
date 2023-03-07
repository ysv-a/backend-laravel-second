<?php

namespace App\Services\Sms;

class SmsApi implements SmsSender
{
    public function send($number, $text): void
    {
        echo "OK!";
    }
}
