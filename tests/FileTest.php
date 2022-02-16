<?php

namespace LojaVirtual\DocumentLinter\Tests;

use LojaVirtual\DocumentLinter\File;

class FileTest extends BaseTesting
{
    protected $file;

    public function setUp()
    {
        $this->file = new File('Content of the file', 'html');
        parent::setUp();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('LojaVirtual\DocumentLinter\File', $this->file);
    }

    public function testGetFilepath()
    {
        $this->assertNotEmpty($this->file->getFilepath());
    }

    public function testDelete()
    {
        $filepath = $this->file->getFilepath();
        $this->assertFileExists($filepath);

        $this->file->delete();
        $this->assertFileNotExists($filepath);
    }

    public function testBuildName()
    {
        $filepath = self::callMethod($this->file, 'buildFilepath', []);
        $parts = explode('/', $filepath);
        $this->assertNotEmpty($parts);
        $this->assertContains('tmp', $parts);
    }
}