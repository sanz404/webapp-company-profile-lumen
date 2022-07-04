<?php

namespace App\Utils;

use Illuminate\Support\Facades\Mail;

class MailSend{

    public static function SendData($receiver, $subject, $sender, $content){
        try {
            Mail::send([], [], function ($message) use ($receiver, $subject, $sender, $content) {
                $message->to($receiver)->subject($subject);
                $message->from($sender)->setBody($content, 'text/html');
            });
        } catch (\Exception $e) {

        }
    }


}
