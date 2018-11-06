<?php

namespace Janrain\core;

use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

/**
 * Class Request
 * @package Janrain\code
 *
 * It contains the request call to Janrain's endpoints according to the request
 * headers, authentications and parameters.
 */
class Request
{

    private $logger;

    /**
     * Request constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Request the Capture Server endpoint using Guzzle.
     *
     * @param string  $captureServerUrl The capture server URL per application.
     * @param string  $serviceUrl The API endpoint to be called.
     * @param array   $data An array for form fields to be sent.
     * @param string  $method The request method: POST, GET, PUT, etc.
     * @param string  $clientId The client_id for application owner.
     * @param string  $clientSecret The secret key for application owner.
     * @param string  $acceptHeader Optional, the accept header request.
     *
     * @return mixed
     */
    public function request(
        $captureServerUrl,
        $serviceUrl,
        $data,
        $method = 'get',
        $clientId = null,
        $clientSecret = null,
        $acceptHeader = 'application/json'
    ) {

        $options = [
            'base_uri' => $captureServerUrl,
            'headers' => [
                'Accept' => $acceptHeader,
            ],
            'auth' => [
                $clientId,
                $clientSecret,
            ],
            'form_params' => $data,
        ];

        if (is_null($clientId) && is_null($clientSecret)) {
            unset($options['auth']);
        }

        $client = new Client();

        $response = $client->request(
            $method,
            $serviceUrl,
            $options
        );

        $body = json_decode($response->getBody());

        if (isset($body->stat) && 'ok' !== $body->stat) {
            $errorMessage = 'Janrain\Request::request || ' .
                'ServiceUrl: ' . $captureServerUrl . $serviceUrl . ' | ' .
                'Data: ' . json_encode($data) . ' | ' .
                'Method: ' . $method . ' | ' .
                'ClientId: ' . $clientId . ' | ' .
                'ResponseBody: ' . json_encode($body);

            $this->logger->error($errorMessage);
        }

        return $body;
    }
}
