<?php

namespace PabloSanches\DocumentLinter\Tests;

use PabloSanches\DocumentLinter\Linter;
use PabloSanches\DocumentLinter\LinterInteface;

class CSSTest extends BaseTesting
{
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testInitialize()
    {
        $css = '.test{}';
        $this->assertInstanceOf('PabloSanches\DocumentLinter\CSS', Linter::CSS($css));
    }

    public function testInstanceOfInterface()
    {
        $css = '.test{}';
        $this->assertInstanceOf('PabloSanches\DocumentLinter\LinterInteface', Linter::CSS($css));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIntializeEmptyContent()
    {
        $html = Linter::CSS();
    }

//    public function testValidate()
//    {
//        $linter = Linter::CSS('.css{background:black;}');
//        $this->assertTrue($linter->isValid());
//    }

    public function testInvalid()
    {
//        $linter = Linter::CSS('.css{background:');
//        $this->assertTrue($linter->isValid());
    }
}