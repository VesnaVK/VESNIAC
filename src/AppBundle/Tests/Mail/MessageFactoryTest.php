<?php

namespace AppBundle\Tests\Mail;

use AppBundle\Mail\MessageFactory;
use PHPUnit_Framework_TestCase;

class MessageFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MessageFactory
     */
    protected $fixture = null;
    
    protected function setUp() {
        parent::setUp();
        
        $this->fixture = new messageFactory();
    }
    
    public function testCreateReturnsMessage()
    {
//        $message = $this->getMock('Swift_Mime_Message');
        $actual = $this->fixture->create();
        
        $this->assertInstanceOf('Swift_Mime_Message', $actual);
    }
    
    public function testMessageHasTo()
    {
        $to = ['abc@example.com' => 'Abigal B. Crumworthy'];
        
        $actual = $this->fixture->create($to);
        
        $this->assertEquals($to, $actual->getTo());
    }
    
    public function testMessageHasFrom()
    {
        $from = ['fromAddress@example.com' => 'From Address'];
        
        $actual = $this->fixture->create(null, $from);
        
        $this->assertEquals($from, $actual->getFrom());
    }
    
    public function testMessageHasSubject()
    {
        $subject = uniqid();
        
        $actual = $this->fixture->create(null, null, $subject);
        
        $this->assertEquals($subject, $actual->getSubject());
    }
    
    public function testMessageHasBody()
    {
        $body = uniqid();
        
        $actual = $this->fixture->create(null, null, null, $body);
        
        $this->assertEquals($body, $actual->getBody()); 
    }
    
    public function testMessageBodyHMTLOnlyIfAltFalse()
    {
        $body = uniqid();
        
        $actual = $this->fixture->create(null, null, null, $body);
        
        $this->assertContains(
            'Content-Type: text/html',
            $actual->getHeaders()->toString(),
            'Message body is not in HTML format.'
        );
        
        $this->assertNotContains(
            'Content-Type: multipart/alternative',
            $actual->getHeaders()->toString(),
            'Message includes an alternative format'
        );
    }
    
    public function testMessageBodyHasMultipartContentIfAltTrue()
    {
        $body = uniqid();
        
        $actual = $this->fixture->create(null, null, null, $body, true);
        
        $this->assertContains(
            'Content-Type: multipart/alternative',
            $actual->getHeaders()->toString(),
            'Message does not include an alternative format for body'
        );
    }
}

