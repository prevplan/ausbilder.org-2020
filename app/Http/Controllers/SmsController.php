<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;

class SmsController extends Controller
{
    public static function send($receiver, $text) {
        // check number format
        if ($receiver[0] == 0 && is_numeric($receiver[0]) && $receiver[1]) { // leading zero
            $receiver = substr_replace( $receiver, '+49', 0, 1 );
        } elseif ($receiver[0] == 0 && is_numeric($receiver[0]) && $receiver[1] == 0 && is_numeric($receiver[1])) { // two leading zero
            $receiver = substr_replace( $receiver, '+', 0, 2 );
        }

        $account_sid = $_ENV["TWILIO_ACCOUNT_SID"];
        $auth_token = $_ENV["TWILIO_AUTH_TOKEN"];

        $twilio_number = $_ENV["TWILIO_SENDER"];

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $receiver,
            array(
                'from' => $twilio_number,
                'body' => $text
            )
        );
    }
}
