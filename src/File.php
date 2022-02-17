<?php

namespace LojaVirtual\DocumentLinter;

/**
 * File Abstraction
 */
class File
{
    const CSS = 'css';
    const HTML = 'html';

    /**
     * @var SplFileObject
     */
    private $file;

    /**
     * @var string
     */
    private $filepath;

    /**
     * @var string
     */
    private $ext;

    /**
     * The constructor
     *
     * @param string $content
     */
    public function __construct($content, $extension)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        if (empty($extension)) {
            throw new \InvalidArgumentException("File extension cannot be empty.");
        }

        $this->filepath = $this->buildFilepath();
        $this->ext = $extension;
        $this->file = new \SplFileObject($this->getFilepath(), 'w+');
        $this->file->fwrite(trim($content));
    }

    /**
     * @return string
     */
    public function getFilepath()
    {
        return realpath($this->filepath) . ".{$this->ext}";
    }

    /**
     * @return void
     */
    public function delete()
    {
        unlink($this->getFilepath());
    }

    /**
     * @return false|string
     */
    private function buildFilepath()
    {
        switch (PHP_OS) {
            case 'Linux':
                return tempnam(sys_get_temp_dir(), rand());
            default:
                $tmp = './tmp/';
                if (!is_dir($tmp)) {
                    mkdir($tmp, 0777, true);
                }
                return $tmp . rand();
        }
    }
}
