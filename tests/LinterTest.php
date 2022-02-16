<?php

namespace PabloSanches\DocumentLinter\Tests;

use PabloSanches\DocumentLinter\Linter;

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

        $this->assertEquals('PabloSanches\DocumentLinter\Documents\ClassName', $className);
    }

    /**
     * @expectedException \PabloSanches\DocumentLinter\LinterException
     */
    public function testNonExistClass()
    {
        $isValid = Linter::NON_EXISTS()->validate();
    }

    public function testIntializeHTML()
    {
        $this->assertInstanceOf('PabloSanches\DocumentLinter\Documents\HTML', Linter::HTML('<div></div>'));
    }

    public function testIntializeCSS()
    {
        $this->assertInstanceOf('PabloSanches\DocumentLinter\Documents\CSS', Linter::CSS('.test{}'));
    }
}