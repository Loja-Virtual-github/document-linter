<?php

namespace PabloSanches\DocumentLinter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;

/**
 * Abstract linter
 */
abstract class AbstractLinter
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string|json
     */
    private $rawBody;

    /**
     * @var \stdClass
     */
    private $body;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var bool
     */
    protected $isValid = false;

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        $this->httpClient = new Client([
            'timeout' => 10,
            'verify' => false
        ]);
    }

    /**
     * Execute the validation
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doCheck()
    {
        $response = $this->httpClient->request('POST', $this->endpoint, [
            'multipart' =>  array(
                [
                    'name' => 'out',
                    'contents' => 'json'
                ],
                [
                    'name' => 'content',
                    'contents' => $this->getContent()
                ]
            ),
        ]);

        $this->parseResponse($response);

        if ($this->getStatusCode() !== 200) {
            throw new BadResponseException("Service {$this->endpoint} out");
        }
    }

    /**
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Parse Response
     *
     * @param Response $response
     * @throws BadResponseException
     * @return void
     */
    private function parseResponse(Response $response)
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