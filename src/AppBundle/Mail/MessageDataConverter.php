<?php

namespace AppBundle\Mail;

use AppBundle\Mail\MessageData;

class MessageDataConverter
{
    public function convert(Request $request)
    {
        $messageData = [];

        $messageData['to']      = "admin@example.com";
        $messageData['from']    = [$request->get('name') => $request->get('email')];
        $messageData['subject'] = 'Contact form submission';
        $messageData['alt']     = true;

        $body = "$request->get('name') \n $request->get('company') \n $request->get('phone') \n $request->get('comment')";

        $messageData['body'] = $body;

        return $messageData;
    }
}

