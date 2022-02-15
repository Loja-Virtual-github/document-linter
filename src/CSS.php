<?php

namespace PabloSanches\DocumentLinter;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use http\Exception\InvalidArgumentException;

/**
 * CSS Linter
 */
class CSS extends AbstractLinter implements LinterInteface
{
    /**
     * @var string
     */
    protected $endpoint = 'http://jigsaw.w3.org/css-validator/validator';

    /**
     * @var string
     */
    protected $fieldName = 'text';

    /**
     * @var string
     */
    protected $content;

    /**
     * Constructor
     *
     * @param string    $content
     * @param bool      $rawDocument
     * @throws \InvalidArgumentException
     */
    public function __construct($content)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        $this->content = $content;

        parent::__construct();
    }

    /**
     * Return the content to check
     *
     * @return string
     */
    protected function getContent()
    {
        return $this->content;
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

    /**
     * Field mapping from validator
     *
     * @return array
     */
    public function getFieldMapping()
    {
        return array(
            'output' => 'xml',
            'profile' => 'css2',
            'usermedium' => 'screen',
            'warning' => 1,
            'lang' => 'pt-BR',
            'text' => $this->getContent()
        );
    }

    /**
     * Returns request params
     *
     * @return array
     */
    protected function getParams()
    {
        return [
            'form_params' =>  $this->getFieldMapping()
        ];
    }

    /**
     * Parse response
     *
     * @param Response $response
     * @return void
     */
    protected function parseResponse(Response $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->rawBody = $response->getBody();

        $this->body = simplexml_load_string($response->getBody()->getContents(), "SimpleXMLElement", LIBXML_NOERROR |  LIBXML_ERR_NONE);;
        exit(var_dump(json_encode($this->body)));

        $this->errors = $this->body->messages;

        if (empty($this->errors)) {
            $this->isValid = true;
        } else {
            $this->isValid = false;
        }
    }
}