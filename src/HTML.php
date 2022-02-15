<?php

namespace PabloSanches\DocumentLinter;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use http\Exception\InvalidArgumentException;

/**
 * HTML Linter
 */
class HTML extends AbstractLinter implements LinterInteface
{
    /**
     * @var string
     */
    protected $endpoint = 'https://html5.validator.nu/';

    /**
     * @var string
     */
    protected $content;

    /**
     * @var bool
     */
    protected $rawDocument = false;

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
     * Set this document as an raw document
     *
     * @return void
     */
    public function isRaw()
    {
        $this->rawDocument = true;
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

    /**
     * Field mapping from validator
     *
     * @return array
     */
    public function getFieldMapping()
    {
        return [
            [
                'name' => 'out',
                'contents' => 'json'
            ],
            [
                'name' => 'content',
                'contents' => $this->getContent()
            ]
        ];
    }

    /**
     * Returns request params
     *
     * @return array
     */
    protected function getParams()
    {
        return [
            'multipart' =>  $this->getFieldMapping()
        ];
    }

    /**
     * Parse Response
     *
     * @param Response $response
     * @throws BadResponseException
     * @return void
     */
    protected function parseResponse(Response $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->rawBody = $response->getBody();

        $this->body = json_decode($response->getBody()->getContents());

        if (json_last_error()) {
            throw new BadResponseException(json_last_error_msg());
        }

        $this->errors = $this->body->messages;

        if (empty($this->errors)) {
            $this->isValid = true;
        } else {
            $this->isValid = false;
        }
    }
}