<?php

namespace LojaVirtual\DocumentLinter\Documents;

use LojaVirtual\DocumentLinter\File;
use LojaVirtual\DocumentLinter\LinterException;
use LojaVirtual\DocumentLinter\Response;

/**
 * Abstract linter
 */
abstract class AbstractLinter
{
    const JAVA_FILE = 'vnu.jar';

    /**
     * @var \LojaVirtual\DocumentLinter\Response
     */
    protected $response;

    /**
     * Returns if a document is valid
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->response->isValid();
    }

    /**
     * Returns all errors founded
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->response->getErrors();
    }

    /**
     * Get java bin filepath
     *
     * @return string
     */
    private function getJavaBin()
    {
        switch (PHP_OS) {
            case 'Linux':
                $javaBin = trim(shell_exec('which java'));
                break;
            case 'WINNT':
                $javaBin = 'java';
                break;
        }

        if (empty($javaBin)) {
            throw new LinterException("java cannot be found");
        }

        return $javaBin;
    }

    /**
     * Get the java bin
     *
     * @return string
     */
    private function getJavaFile()
    {
        $javaFile = realpath(__DIR__ . '/../../bin/') . '/' . self::JAVA_FILE;
        if (!file_exists($javaFile)) {
            throw new LinterException("Java file cannot be found.");
        }

        return $javaFile;
    }

    /**
     * Get the linter name
     *
     * @param $class
     * @return string
     */
    protected static function extractLinterName($class)
    {
        $parts = explode('\\', $class);
        return mb_strtolower(end($parts));
    }

    /**
     * Get command flag
     *
     * @return string
     */
    public function getFlag($linterName)
    {
        switch ($linterName) {
            case 'html':
                return '--html --skip-non-html';
            case 'css':
                return '--css --skip-non-css --also-check-css';
        }
    }

    /**
     * Execute command
     *
     * @param $linterName
     * @return void
     */
    protected function execute($linterName)
    {
        $linterName = mb_strtolower($linterName);
        $file = new File($this->getContent(), $linterName);

        $command = sprintf(
            "%s -jar %s %s --stdout --exit-zero-always --errors-only --no-stream --format json %s",
            $this->getJavaBin(),
            $this->getJavaFile(),
            $this->getFlag($linterName),
            $file->getFilepath()
        );


        $output = shell_exec($command);

        // Delete tmp file
        $file->delete();

        if (empty($output)) {
            throw new \RuntimeException("Cannot get the command output.");
        }

        $this->response = new Response($output);
    }
}