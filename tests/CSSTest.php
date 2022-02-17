<?php

namespace LojaVirtual\DocumentLinter\Tests;

use LojaVirtual\DocumentLinter\Documents\CSS;
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

    public function testValidExtractCSSFromHTML()
    {
        $dirtyStyle = '
            <style>
            .containerInputLoginCadastro.noBorder
            {
               border:none;
            }
            
            .containerInputLoginCadastro .inputTextPadrao
            {
                width:100%;
            }
            </style>
              <div class="containerTermosCadastro">
                        <div class="containerInputLogin">
                            <div class="boxBotaoPadraoTema boxBotaoRetratil">
                                <div class="conteudoBotaoPadraoTema">
                                    <p>teste</p>
                                </div>
                            </div>
                    </div>
              </div>
        ';

        $linter = Linter::CSS($dirtyStyle, true);
        $this->assertTrue($linter->isValid());
        $this->assertEmpty($linter->getErrors());
    }

    public function testInvalidExtractCSSFromHTML()
    {
        $dirtyStyle = '
            <style>
            .containerInputLoginCadastro.noBorder
            {
            
            .containerInputLoginCadastro .inputTextPadrao
            {
                width:100%;
            }
            </style>
              <div class="containerTermosCadastro">
                        <div class="containerInputLogin">
                            <div class="boxBotaoPadraoTema boxBotaoRetratil">
                                <div class="conteudoBotaoPadraoTema">
                                    <p>teste</p>
                                </div>
                            </div>
                    </div>
              </div>
        ';

        $linter = Linter::CSS($dirtyStyle, true);
        $this->assertFalse($linter->isValid());
        $this->assertNotEmpty($linter->getErrors());
    }
}