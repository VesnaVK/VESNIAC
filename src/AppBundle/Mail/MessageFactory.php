<?php

namespace AppBundle\Mail;

use Swift_Message;

class MessageFactory
{
    public function create($to = null, $from = null, $subject = null, $body = null, $alt = false)
    {
        $message = new Swift_Message();
        $message->setTo($to);
        $message->setFrom($from);
        $message->setSubject($subject);
        $message->setBody($body, 'text/html');
        
        if (true === $alt)
        {
            $message->addPart($body, 'text/plain');
        }
        
        return $message; 
    }
}
