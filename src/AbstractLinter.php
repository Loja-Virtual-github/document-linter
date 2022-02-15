<?php

namespace PabloSanches\DocumentLinter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use http\Exception\RuntimeException;

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
            'timeout' => 5,
            'verify' => false
        ]);
    }

    protected function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Execute the validation
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doCheck()
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->endpoint,
                $this->getParams()
            );
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new BadResponseException("Service {$this->endpoint} out");
        }

        $this->parseResponse($response);
    }
}