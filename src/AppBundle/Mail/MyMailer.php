<?php

namespace AppBundle\Mail;

use AppBundle\Mail\MessageFactory;
use Swift_Mailer;
use Swift_Message;

class MyMailer
{
    /**
     * MessageFactory
     */
    protected $messageFactory = null;
    
    /**
     * Swift_Mailer
     */
    protected $mailer = null;
    
    /**
     * @param MessageFactory $messageFactory
     * @param Swift_Mailer $mailer
     */
    public function __construct(MessageFactory $messageFactory, Swift_Mailer $mailer)
    {
        $this->messageFactory = $messageFactory;
        $this->mailer         = $mailer;
    }
    
    public function process(array $messageData)
    {
        $message = $this->messageFactory->create(
                $messageData['to'],
                $messageData['from'],
                $messageData['subject'],
                $messageData['body'],
                $messageData['alt']
        );
        
        $this->mailer->send($message);
    }
}

