<?php

namespace AppBundle\Tests\Mail;

use AppBundle\Mail\MessageDataConverter;
use PHPUnit_Framework_TestCase;

class MessageFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MessageDataConverter
     */
    protected $fixture = null;

    protected function setUp() {
        parent::setUp();

        $this->fixture = new MessageDataConverter();
    }

    public function testConverterReturnsMessageData()
    {
        $formData = [];

        $actual = $this->fixture->convert($formData);

        $this->assertInstanceOf('AppBundle\\Mail\\MessageData', $actual);
    }

    public function testMessageDataHasTo()
    {
        $formData       = [];
        $formData['to'] = ['abc@example.com' => 'Abigal B. Crumworthy'];

        $actual = $this->fixture->create($to);

        $this->assertEquals($formData['to'], $actual->getTo());
    }

    public function testMessageDataHasFrom()
    {
        $from = ['fromAddress@example.com' => 'From Address'];

        $actual = $this->fixture->create(null, $from);

        $this->assertEquals($from, $actual->getFrom());
    }

    public function testMessageDataHasSubject()
    {
        $subject = uniqid();

        $actual = $this->fixture->create(null, null, $subject);

        $this->assertEquals($subject, $actual->getSubject());
    }

    public function testMessageDataHasBody()
    {
        $body = uniqid();

        $actual = $this->fixture->create(null, null, null, $body);

        $this->assertEquals($body, $actual->getBody());
    }

}

