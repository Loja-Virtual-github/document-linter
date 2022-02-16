<?php

namespace LojaVirtual\DocumentLinter\Tests;

use LojaVirtual\DocumentLinter\LinterException;
use LojaVirtual\DocumentLinter\Response;

class ResponseTest extends BaseTesting
{
    protected $response;

    protected $jsonMock = '{"messages":[]}';

    public function setUp()
    {
        $this->response = new Response($this->jsonMock);
        parent::setUp();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Response', $this->response);
    }

    public function testIsValid()
    {
        $this->assertTrue($this->response->isValid());
        $this->assertEmpty($this->response->getErrors());
    }

    public function testIsInvalid()
    {
        $jsonError = '{"messages":["Error1", "Error2"]}';
        $response = new Response($jsonError);
        $this->assertFalse($response->isValid());
        $this->assertNotEmpty($response->getErrors());
    }

    /**
     * @expectedException LojaVirtual\DocumentLinter\LinterException
     */
    public function testInvalidOutput()
    {
        $response = new Response('<div></div>');
    }
}