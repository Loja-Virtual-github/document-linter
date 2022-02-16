<?php

namespace LojaVirtual\DocumentLinter\Tests;

use LojaVirtual\DocumentLinter\Linter;

class HTMLTest extends BaseTesting
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testInitialize()
    {
        $html = '<div>test</div>';
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Documents\HTML', Linter::HTML($html));
    }

    public function testInstanceOfInterface()
    {
        $html = '<div>test</div>';
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Documents\LinterInteface', Linter::HTML($html));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIntializeEmptyContent()
    {
        $html = Linter::HTML();
    }

    public function testValidate()
    {
        $html = Linter::HTML('<div>test</div>');
        $this->assertTrue($html->isValid());
    }

    public function testInvalidDocument()
    {
        $html = Linter::HTML('<div>test<div>');
        $this->assertFalse($html->isValid());
        $this->assertNotEmpty($html->getErrors());
    }

    public function testValidateRawDocument()
    {
        $doc = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>HTML Linter</title>
            </head>
            <body>
                <p>Test</p>
            </body>
            </html>
        ";
        $html = Linter::HTML($doc, true);
        $this->assertTrue($html->isValid());
    }

    public function testInvalidateRawDocument()
    {
        $doc = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>HTML Linter</title>
            </head>
            <body>
                <p>Test
                <div>Test
            </body>
            </html>
        ";
        $html = Linter::HTML($doc, true);
        $this->assertFalse($html->isValid());
        $this->assertNotEmpty($html->getErrors());
    }
}