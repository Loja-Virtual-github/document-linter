<?php

namespace LojaVirtual\DocumentLinter;

use LojaVirtual\DocumentLinter\LinterException;

/**
 * Response Class
 */
class Response
{
    private $output;

    /**
     * Constructor
     *
     * @param $output
     */
    public function __construct($output)
    {
        $output = json_decode($output);
        if (json_last_error()) {
            throw new LinterException(json_last_error_msg());
        }

        $this->output = $output;
    }

    /**
     * Returns if document is valid
     *
     * @return bool
     */
    public function isValid()
    {
        return empty($this->output->messages);
    }

    /**
     * Returns all errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->output->messages;
    }
}