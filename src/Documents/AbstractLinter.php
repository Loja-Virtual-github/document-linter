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
        $javaBin = trim(shell_exec('which java'));
        if (empty($javaBin)) {
            throw new LinterException("java cannot be found");
        }

        return $javaBin;
    }

    private function getJavaFile()
    {
        $javaFile = realpath(__DIR__ . '/../../bin/') . '/' . self::JAVA_FILE;
        if (!file_exists($javaFile)) {
            throw new LinterException("Java file cannot be found.");
        }
    }

    protected static function extractLinterName($class)
    {
        $parts = explode('\\', $class);
        return mb_strtolower(end($parts));
    }

    protected function execute($linterName)
    {
        $file = new File($this->getContent(), mb_strtoupper($linterName));

        $command = sprintf(
            "%s -jar %s %s --stdout --exit-zero-always --errors-only --no-stream --format json %s",
            $this->getJavaBin(),
            $this->getJavaFile(),
            $file->getFlag($linterName),
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