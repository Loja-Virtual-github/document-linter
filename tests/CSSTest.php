<?php

namespace LojaVirtual\DocumentLinter\Tests;

use LojaVirtual\DocumentLinter\Linter;

class CSSTest extends BaseTesting
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testInitialize()
    {
        $css = '.test{}';
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Documents\CSS', Linter::CSS($css));
    }

    public function testInstanceOfInterface()
    {
        $css = '.test{}';
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Documents\LinterInteface', Linter::CSS($css));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIntializeEmptyContent()
    {
        $html = Linter::CSS();
    }

    public function testValidate()
    {
        $linter = Linter::CSS('.css{background:black;}');
        $this->assertTrue($linter->isValid());
    }

    public function testInvalid()
    {
        $linter = Linter::CSS('.css{background:');
        $this->assertFalse($linter->isValid());
        $this->assertNotEmpty($linter->getErrors());
    }
}