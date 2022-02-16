<?php

namespace PabloSanches\DocumentLinter;

class Response
{
    private $output;

    public function __construct($output)
    {
        $output = json_decode($output);
        if (json_last_error()) {
            throw new RuntimeException(json_last_error_msg());
        }

        $this->output = $output;
    }

    public function isValid()
    {
        return empty($this->output->messages);
    }

    public function getErrors()
    {
        return $this->output->messages;
    }
}