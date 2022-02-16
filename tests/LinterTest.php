<?php

namespace LojaVirtual\DocumentLinter\Tests;

use LojaVirtual\DocumentLinter\Linter;

class LinterTest extends BaseTesting
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testBuildClassName()
    {
        $className = self::callMethod(
            new Linter(),
            'buildLinterClassName',
            ['ClassName']
        );

        $this->assertEquals('LojaVirtual\DocumentLinter\Documents\ClassName', $className);
    }

    /**
     * @expectedException \LojaVirtual\DocumentLinter\LinterException
     */
    public function testNonExistClass()
    {
        $isValid = Linter::NON_EXISTS()->validate();
    }

    public function testIntializeHTML()
    {
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Documents\HTML', Linter::HTML('<div></div>'));
    }

    public function testIntializeCSS()
    {
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\Documents\CSS', Linter::CSS('.test{}'));
    }
}