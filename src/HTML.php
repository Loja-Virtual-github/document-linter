<?php

namespace PabloSanches\DocumentLinter;

use http\Exception\InvalidArgumentException;

/**
 * HTML Linter
 */
class HTML extends AbstractLinter implements LinterInteface
{
    protected $endpoint = 'https://html5.validator.nu/';

    /**
     * @var string
     */
    protected $content;

    /**
     * @var bool
     */
    protected $rawDocument;

    /**
     * Constructor
     *
     * @param string    $content
     * @param bool      $rawDocument
     * @throws \InvalidArgumentException
     */
    public function __construct($content, $rawDocument = false)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        $this->content = $content;
        $this->rawDocument = $rawDocument;

        parent::__construct();
    }

    /**
     * Return the content to check
     *
     * @return string
     */
    protected function getContent()
    {
        if ($this->rawDocument) {
            return $this->content;
        }

        return "
            <!DOCTYPE html>
            <html>
            <head>
                <title>HTML Linter</title>
            </head>
            <body>
                {$this->content}
            </body>
            </html>
        ";
    }

    /**
     * Returns if a document is valid
     *
     * @return bool
     */
    public function isValid()
    {
        $this->doCheck();

        return $this->isValid;
    }

    /**
     * Returns all errors founded
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}