<?php

namespace AppBundle\Tests\Mail;

use AppBundle\Mail\MessageFactory;
use AppBundle\Mail\MyMailer;
use PHPUnit_Framework_TestCase;
use Swift_Mailer;

class MyMailerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MyMailer
     */
    protected $fixture = null;

    /**
     * @var MessageFactory
     */
    protected $messageFactory = null;

    /**
     * @var Swift_Mailer
     */
    protected $mailer = null;

    protected function setUp() {
        parent::setUp();

        $this->messageFactory = $this->getMock('AppBundle\\Mail\\MessageFactory', [], [], '', false, false);
        $this->mailer = $this->getMock('Swift_Mailer', [], [], '', false, false);

        $this->fixture = new MyMailer($this->messageFactory, $this->mailer);
    }

    public function testMessageFactoryIsCalledWithMessageData()
    {
        $to      = [uniqid()];
        $from    = [uniqid()];
        $subject = uniqid();
        $body    = uniqid();
        $alt     = null;

        $messageData = [
            'to'      => $to,
            'from'    => $from,
            'subject' => $subject,
            'body'    => $body,
            'alt'     => $alt,
        ];

        $message = $this->getMock('Swift_Mime_Message');
        $message->method('getTo')->willReturn($to);
        $message->method('getFrom')->willReturn($from);
        $message->method('getSubject')->willReturn($subject);
        $message->method('getBody')->willReturn($body);

        $this->messageFactory
            ->expects($this->once())
            ->method('create')
            ->with($to, $from, $subject, $body, $alt)
            ->willReturn($message);

        $this->fixture->process($messageData);
    }

    public function testMailerIsCalledWithMessage()
    {
        $messageData = [
            'to'      => '',
            'from'    => '',
            'subject' => '',
            'body'    => '',
            'alt'     => null,
        ];

        $message = $this->getMock('Swift_Mime_Message');
        $this->messageFactory->method('create')
            ->willReturn($message);

        $this->mailer->expects($this->once())
            ->method('send')
            ->with($message);

        $this->fixture->process($messageData);
    }

    public function testMailNotSentWhenShouldNotBe()
    {
        $this->mailer->expects($this-> never())
            ->method('send');

        $this->fixture->process([]);
    }
}
